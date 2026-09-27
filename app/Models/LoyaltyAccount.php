<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoyaltyAccount extends Model
{
    protected $fillable = [
        'user_id',
        'tier',
        'points_balance',
        'lifetime_points',
        'cashback_balance',
        'discount_rate',
    ];

    protected $casts = [
        'points_balance' => 'integer',
        'lifetime_points' => 'integer',
        'cashback_balance' => 'decimal:2',
        'discount_rate' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTierNameAttribute(): string
    {
        return match ($this->tier) {
            'diamond' => 'المرتبة السيادية الماسية',
            'platinum' => 'المرتبة البلاتينية',
            'gold' => 'المرتبة الذهبية',
            default => 'المرتبة الفضية',
        };
    }
}
