<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AffiliateCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'affiliate_referral_id',
        'order_reference',
        'order_amount',
        'commission_amount',
        'currency',
        'status',
        'paid_at',
    ];

    protected $casts = [
        'order_amount' => 'float',
        'commission_amount' => 'float',
        'paid_at' => 'datetime',
    ];

    public function referral(): BelongsTo
    {
        return $this->belongsTo(AffiliateReferral::class, 'affiliate_referral_id');
    }
}
