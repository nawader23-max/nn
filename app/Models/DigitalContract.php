<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DigitalContract extends Model
{
    protected $fillable = [
        'contract_number',
        'user_id',
        'title',
        'entity_name',
        'contract_type',
        'amount',
        'currency',
        'status',
        'pdf_path',
        'signature_hash',
        'signed_at',
        'expires_at',
        'parties',
        'terms_meta',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'signed_at' => 'datetime',
        'expires_at' => 'datetime',
        'parties' => 'array',
        'terms_meta' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
