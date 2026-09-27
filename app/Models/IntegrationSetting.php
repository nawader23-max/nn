<?php

namespace App\Models;

use App\Casts\EncryptedString;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class IntegrationSetting extends Model
{
    protected $fillable = [
        'provider',
        'key',
        'value',
        'group',
        'is_active',
        'is_secret',
        'environment',
        'label',
        'description',
    ];

    protected $hidden = ['value'];

    protected $casts = [
        'value' => EncryptedString::class,
        'is_active' => 'boolean',
        'is_secret' => 'boolean',
    ];

    /**
     * Get a setting value with fallback to config and env
     */
    public static function getVal(string $provider, string $key, ?string $default = null): ?string
    {
        try {
            if (Schema::hasTable('integration_settings')) {
                $setting = static::where('provider', $provider)->where('key', $key)->first();
                if ($setting && ! empty($setting->value)) {
                    return $setting->value;
                }
            }
        } catch (\Throwable $e) {
            // Graceful fallback to config and env
        }

        $configVal = config("services.{$provider}.{$key}");
        if (! empty($configVal)) {
            return $configVal;
        }

        $envKey = strtoupper("{$provider}_{$key}");

        return env($envKey, $default);
    }

    /**
     * Set or update setting value
     */
    public static function setVal(string $provider, string $key, ?string $value, string $group = 'general', ?string $label = null): static
    {
        return static::updateOrCreate(
            ['provider' => $provider, 'key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'label' => $label ?? ucfirst($provider).' '.ucfirst($key),
                'is_active' => ! empty($value),
            ]
        );
    }

    /**
     * Masked preview — safe for views, never renders raw secret.
     */
    public function maskedValue(): string
    {
        $value = (string) $this->value;
        if ($value === '') {
            return '';
        }
        if (! $this->is_secret) {
            return $value;
        }
        if (mb_strlen($value) <= 8) {
            return str_repeat('•', 8);
        }

        return mb_substr($value, 0, 4).str_repeat('•', 8).mb_substr($value, -4);
    }
}
