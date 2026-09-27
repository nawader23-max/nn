<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DigitalContract extends Model
{
    protected $fillable = [
        'contract_number',
        'user_id',
        'service_request_id',
        'title',
        'entity_name',
        'contract_type',
        'amount',
        'currency',
        'status',
        'verification_token',
        'pdf_path',
        'signature_path',
        'document_sha256',
        'signature_hash',
        'signed_at',
        'otp_verified_at',
        'expires_at',
        'parties',
        'terms_meta',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'signed_at' => 'datetime',
        'otp_verified_at' => 'datetime',
        'expires_at' => 'datetime',
        'parties' => 'array',
        'terms_meta' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function serviceRequest(): BelongsTo
    {
        return $this->belongsTo(ServiceRequest::class);
    }
}

