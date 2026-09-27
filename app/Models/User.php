<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'phone_e164',
        'phone_verified_at',
        'national_id',
        'company_name',
        'kyc_tier',
        'two_factor_enabled',
        'referral_code',
    ];

    protected $hidden = ['password', 'email', 'national_id', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_enabled' => 'boolean',
            'kyc_tier' => 'integer',
        ];
    }

    // ── RBAC Helpers ────────────────────────────────────────────────────────
    public function isAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAdvisor(): bool
    {
        return in_array($this->role, ['sovereign_advisor', 'super_admin']);
    }

    public function isClient(): bool
    {
        return $this->role === 'corporate_client';
    }

    public function isInvestor(): bool
    {
        return in_array($this->role, ['investor', 'super_admin']);
    }

    public function isDeveloper(): bool
    {
        return in_array($this->role, ['developer', 'super_admin']);
    }

    public function hasRole(string ...$roles): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return in_array($this->role, $roles);
    }

    // ── Relationships ───────────────────────────────────────────────────────
    public function contracts(): HasMany
    {
        return $this->hasMany(DigitalContract::class);
    }

    public function loyaltyAccount(): HasOne
    {
        return $this->hasOne(LoyaltyAccount::class);
    }

    public function walletTransactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function affiliateReferrals(): HasMany
    {
        return $this->hasMany(AffiliateReferral::class);
    }

    public function apiTokens(): HasMany
    {
        return $this->hasMany(DeveloperApiToken::class);
    }

    public function webhookEndpoints(): HasMany
    {
        return $this->hasMany(WebhookEndpoint::class);
    }

    public function aiStudioGenerations(): HasMany
    {
        return $this->hasMany(AiStudioGeneration::class);
    }

    public function serviceRequests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function clientNotifications(): HasMany
    {
        return $this->hasMany(UserNotification::class);
    }
}
