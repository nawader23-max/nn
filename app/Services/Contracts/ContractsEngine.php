<?php

namespace App\Services\Contracts;

use App\Models\DigitalContract;
use Illuminate\Support\Str;

class ContractsEngine
{
    /**
     * Create a digital contract
     */
    public function createContract(array $data): DigitalContract
    {
        $contractNo = 'NW-CNT-'.date('Y').'-'.strtoupper(Str::random(6));

        return DigitalContract::create([
            'contract_number' => $contractNo,
            'user_id' => $data['user_id'] ?? null,
            'title' => $data['title'],
            'entity_name' => $data['entity_name'],
            'contract_type' => $data['contract_type'] ?? 'bilateral_jv',
            'amount' => $data['amount'] ?? 0,
            'currency' => $data['currency'] ?? 'SAR',
            'status' => 'pending_signature',
            'parties' => $data['parties'] ?? [],
            'terms_meta' => $data['terms_meta'] ?? [],
            'expires_at' => now()->addYear(),
        ]);
    }

    /**
     * Digitally sign a contract with cryptographic hash
     */
    public function signContract(DigitalContract $contract, string $signerName, string $signerIp): DigitalContract
    {
        $payload = "{$contract->contract_number}|{$signerName}|{$signerIp}|".now()->toIso8601String();
        $hash = hash('sha256', $payload);

        $contract->update([
            'signature_hash' => $hash,
            'signed_at' => now(),
            'status' => 'active',
            'terms_meta' => array_merge($contract->terms_meta ?? [], [
                'signed_by' => $signerName,
                'signer_ip' => $signerIp,
                'law' => 'نظام التعاملات الإلكترونية السعودي & US E-SIGN Act',
            ]),
        ]);

        return $contract;
    }
}
