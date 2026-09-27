<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ReverseOtpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class ReverseOtpController extends Controller
{
    public function __construct(private readonly ReverseOtpService $service) {}

    public function generate(Request $request): JsonResponse
    {
        $this->assertBrowserCsrf($request);
        abort_unless(config('reverse_otp.enabled'), 503, 'Reverse authentication is not enabled.');
        $data = $request->validate(['phone' => ['required', 'string', 'max:32'], 'purpose' => ['nullable', 'in:login,verify']]);
        $purpose = $data['purpose'] ?? 'login';
        $phone = $this->service->normalizePhone($data['phone']);

        if ($purpose === 'verify') {
            abort_unless(Auth::check(), 403);
            $user = $request->user();
            if (User::where('phone_e164', $phone)->whereKeyNot($user->id)->exists()) {
                throw ValidationException::withMessages(['phone' => 'هذا الرقم مرتبط بحساب آخر.']);
            }
        } else {
            $user = User::where('phone_e164', $phone)->whereNotNull('phone_verified_at')->first();
            if (! $user || $user->two_factor_enabled || in_array($user->role, config('reverse_otp.privileged_roles'), true)) {
                throw ValidationException::withMessages(['phone' => 'لا يتوفر دخول WhatsApp لهذا الحساب.']);
            }
        }

        return response()->json($this->service->issue($request, $user, $phone, $purpose));
    }

    public function checkStatus(Request $request): JsonResponse
    {
        $token = (string) $request->query('token');
        abort_if($token === '', 422, 'Token is required.');
        $result = $this->service->status($request, $token);
        if (($result['status'] ?? null) === 'verified') {
            if (($result['purpose'] ?? 'login') === 'login') {
                $user = User::find($result['user_id']);
                if (! $user || $user->two_factor_enabled || in_array($user->role, config('reverse_otp.privileged_roles'), true)) {
                    return response()->json(['status' => 'invalid']);
                }
                Auth::loginUsingId($user->id);
                $request->session()->regenerate();
            }
            $result['redirect'] = route('dashboard');
        }
        return response()->json($result);
    }

    public function receiveWhatsApp(Request $request): JsonResponse
    {
        $secret = (string) config('reverse_otp.listener_secret');
        $timestamp = (string) $request->header('X-Reverse-Otp-Timestamp');
        $signature = (string) $request->header('X-Reverse-Otp-Signature');
        $messageId = (string) $request->header('X-Reverse-Otp-Message-Id');
        abort_if($secret === '' || ! ctype_digit($timestamp) || abs(time() - (int) $timestamp) > 60 || $messageId === '', 401);
        $expected = hash_hmac('sha256', $timestamp.'.'.$messageId.'.'.$request->getContent(), $secret);
        abort_unless(hash_equals($expected, $signature), 401);
        abort_unless(Cache::store((string) config('reverse_otp.cache_store'))->add('reverse-otp:message:'.$messageId, true, now()->addMinutes(5)), 409);
        $data = $request->validate(['token' => ['required', 'string', 'max:64'], 'phone' => ['required', 'string', 'max:32']]);
        return response()->json(['verified' => $this->service->confirm($data['token'], $data['phone'])]);
    }

    public function pairingStatus(Request $request): JsonResponse
    {
        abort_unless($request->user()?->isAdmin(), 403);
        $secret = (string) config('reverse_otp.listener_secret');
        abort_if($secret === '', 503, 'Listener is not configured.');
        $response = Http::timeout(2)->withToken($secret)->get(rtrim((string) config('reverse_otp.listener_url'), '/').'/status');
        return response()->json($response->successful() ? $response->json() : ['status' => 'unavailable'], $response->successful() ? 200 : 503);
    }

    public function pairingPage(Request $request)
    {
        abort_unless($request->user()?->isAdmin(), 403);

        return view('pages.dashboard.reverse-otp-pairing');
    }

    public function verificationPage(Request $request)
    {
        return view('pages.dashboard.phone-verification');
    }

    private function assertBrowserCsrf(Request $request): void
    {
        $provided = (string) $request->header('X-CSRF-TOKEN');
        abort_unless($provided !== '' && hash_equals($request->session()->token(), $provided), 419);
    }
}
