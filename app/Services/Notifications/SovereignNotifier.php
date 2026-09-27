<?php

namespace App\Services\Notifications;

use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Dual-channel lifecycle notifier: durable in-app record + best-effort
 * WhatsApp push through the local Baileys reverse-OTP listener (/notify).
 */
final class SovereignNotifier
{
    public function notify(User $user, string $title, string $body, ?string $actionUrl = null, string $type = 'lifecycle'): void
    {
        UserNotification::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'body' => $body,
            'action_url' => $actionUrl,
        ]);

        $phone = $user->phone_e164 ?: $user->phone;
        if (!$phone || !$user->phone_verified_at) {
            return; // PDPL hygiene: never message an unverified number.
        }

        try {
            $secret = (string) config('reverse_otp.listener_secret');
            if ($secret === '') {
                return;
            }
            Http::timeout(3)
                ->withToken($secret)
                ->post(rtrim((string) config('reverse_otp.listener_url'), '/').'/notify', [
                    'phone' => $phone,
                    'text' => "نوادر السيادية | {$title}\n{$body}",
                ]);
        } catch (Throwable $e) {
            Log::debug('WhatsApp lifecycle notify skipped: '.$e->getMessage());
        }
    }
}
