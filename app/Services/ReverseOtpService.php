<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class ReverseOtpService
{
    public function normalizePhone(string $value): string
    {
        $digits = preg_replace('/\D+/', '', $value) ?? '';
        $country = (string) config('reverse_otp.default_country_code');

        if (str_starts_with($digits, '00')) {
            $digits = substr($digits, 2);
        } elseif (str_starts_with($digits, '0')) {
            $digits = $country.substr($digits, 1);
        }

        if (! preg_match('/^[1-9][0-9]{7,14}$/', $digits)) {
            throw ValidationException::withMessages(['phone' => 'أدخل رقم هاتف دولياً صالحاً.']);
        }

        return '+'.$digits;
    }

    public function issue(Request $request, User $user, string $phone, string $purpose): array
    {
        $store = $this->store();
        $expiresAt = now()->addSeconds((int) config('reverse_otp.ttl_seconds'));

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $token = $this->token();
            $hash = hash('sha256', $token);
            $payload = [
                'user_id' => $user->id,
                'phone' => $phone,
                'purpose' => $purpose,
                'session_hash' => hash('sha256', $request->session()->getId()),
                'status' => 'pending',
                'created_at' => now()->toIso8601String(),
                'expires_at' => $expiresAt->toIso8601String(),
            ];

            if ($store->add($this->key($hash), $payload, $expiresAt)) {
                $request->session()->put('reverse_otp.'.$hash, true);

                return [
                    'token' => $token,
                    'expires_at' => $expiresAt->toIso8601String(),
                    'whatsapp_url' => $this->deepLink('https://wa.me/', config('reverse_otp.whatsapp_number'), $token),
                    'sms_url' => $this->smsLink(config('reverse_otp.sms_number'), $token),
                ];
            }
        }

        throw ValidationException::withMessages(['phone' => 'تعذر إنشاء رمز آمن، حاول مرة أخرى.']);
    }

    public function status(Request $request, string $token): array
    {
        $hash = hash('sha256', strtoupper(trim($token)));
        if (! $request->session()->pull('reverse_otp.'.$hash, false)) {
            return ['status' => 'invalid'];
        }
        $request->session()->put('reverse_otp.'.$hash, true);

        return $this->withLock($hash, function (array $payload) use ($request, $hash): array {
            if (! hash_equals($payload['session_hash'], hash('sha256', $request->session()->getId()))) {
                return ['status' => 'invalid'];
            }
            if ($payload['status'] !== 'verified') {
                return ['status' => $payload['status']];
            }

            $user = User::find($payload['user_id']);
            if (! $user) {
                $this->store()->forget($this->key($hash));
                return ['status' => 'invalid'];
            }

            if ($payload['purpose'] === 'verify') {
                $user->forceFill(['phone' => $payload['phone'], 'phone_e164' => $payload['phone'], 'phone_verified_at' => now()])->save();
            }

            $this->store()->forget($this->key($hash));
            $request->session()->forget('reverse_otp.'.$hash);

            return ['status' => 'verified', 'user_id' => $user->id, 'purpose' => $payload['purpose']];
        });
    }

    public function confirm(string $token, string $phone): bool
    {
        $hash = hash('sha256', strtoupper(trim($token)));
        $phone = $this->normalizePhone($phone);

        return $this->withLock($hash, function (array $payload) use ($phone, $hash): bool {
            if ($payload['status'] !== 'pending' || ! hash_equals($payload['phone'], $phone)) {
                return false;
            }
            $payload['status'] = 'verified';
            $payload['verified_at'] = now()->toIso8601String();
            $this->store()->put($this->key($hash), $payload, Carbon::parse($payload['expires_at']));
            return true;
        }, false);
    }

    private function withLock(string $hash, callable $callback, mixed $default = null): mixed
    {
        $store = $this->store();
        $lock = $store->lock('reverse-otp:lock:'.$hash, 5);
        try {
            return $lock->block(2, function () use ($store, $hash, $callback, $default) {
                $payload = $store->get($this->key($hash));
                return is_array($payload) ? $callback($payload) : $default;
            });
        } catch (LockTimeoutException) {
            return $default;
        }
    }

    private function store(): \Illuminate\Contracts\Cache\Repository
    {
        return Cache::store((string) config('reverse_otp.cache_store'));
    }

    private function key(string $hash): string { return 'reverse-otp:challenge:'.$hash; }

    private function token(): string
    {
        return (string) config('reverse_otp.prefix').'-'.strtoupper(substr(rtrim(strtr(base64_encode(random_bytes(10)), '+/', 'AB'), '='), 0, 10));
    }

    private function deepLink(string $base, ?string $number, string $token): ?string
    {
        $number = preg_replace('/\D+/', '', (string) $number);
        return $number !== '' ? $base.$number.'?text='.rawurlencode('AUTH '.$token) : null;
    }

    private function smsLink(?string $number, string $token): ?string
    {
        $number = preg_replace('/\D+/', '', (string) $number);
        return $number !== '' ? 'sms:+'.$number.'?body='.rawurlencode('AUTH '.$token) : null;
    }
}
