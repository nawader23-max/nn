<?php

namespace App\Services\Consent;

use App\Models\ConsentRecord;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * PDPL (اللائحة التنفيذية لحماية البيانات الشخصية) explicit-consent ledger.
 * Every acceptance is fingerprinted: user + purpose + policy version + IP + UA + timestamp.
 */
final class PdplConsentService
{
    public const POLICY_VERSION = '1.0';

    public function record(User $user, Request $request, string $purpose, string $policyVersion = self::POLICY_VERSION): ConsentRecord
    {
        $ip = $request->ip();
        $ua = mb_substr((string) $request->userAgent(), 0, 250);
        $acceptedAt = now();

        $fingerprint = hash('sha256', implode('|', [
            $user->id,
            $user->email,
            $purpose,
            $policyVersion,
            $ip,
            $ua,
            $acceptedAt->toIso8601String(),
        ]));

        return ConsentRecord::updateOrCreate(
            ['user_id' => $user->id, 'purpose' => $purpose, 'policy_version' => $policyVersion],
            [
                'fingerprint' => $fingerprint,
                'ip_address' => $ip,
                'user_agent' => $ua,
                'accepted_at' => $acceptedAt,
            ]
        );
    }

    public function accepted(User $user, string $purpose, string $policyVersion = self::POLICY_VERSION): bool
    {
        return ConsentRecord::query()
            ->where('user_id', $user->id)
            ->where('purpose', $purpose)
            ->where('policy_version', $policyVersion)
            ->exists();
    }
}
