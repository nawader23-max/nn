<?php

namespace App\Services\Integrations;

use App\Models\IntegrationSetting;
use Throwable;

/** Runtime credential resolver: encrypted DB vault first, then config/services (env-backed, cache-safe). */
final class IntegrationCredentials
{
    public function get(string $provider, string $key, ?string $default = null): ?string
    {
        foreach ([$this->fromVault($provider, $key), $this->fromConfig($provider, $key)] as $value) {
            if (is_string($value) && trim($value) !== '') {
                return trim($value);
            }
        }

        return $default;
    }

    /** @param array<int, string> $keys */
    public function has(string $provider, array $keys): bool
    {
        foreach ($keys as $key) {
            if ($this->get($provider, $key) === null) {
                return false;
            }
        }

        return true;
    }

    /** @param array<int, string> $keys @return array<int, string> */
    public function missing(string $provider, array $keys): array
    {
        return array_values(array_filter($keys, fn (string $key): bool => $this->get($provider, $key) === null));
    }

    public function source(string $provider, string $key): ?string
    {
        if ($this->fromVault($provider, $key) !== null) {
            return 'vault';
        }

        return $this->fromConfig($provider, $key) !== null ? 'env' : null;
    }

    /** @param array<int, string> $order @param array<int, string> $keys */
    public function firstConfigured(array $order, array $keys): ?string
    {
        foreach ($order as $provider) {
            if ($this->has($provider, $keys)) {
                return $provider;
            }
        }

        return null;
    }

    private function fromVault(string $provider, string $key): ?string
    {
        try {
            return IntegrationSetting::getVal($provider, $key);
        } catch (Throwable) {
            return null;
        }
    }

    private function fromConfig(string $provider, string $key): ?string
    {
        $value = config("services.{$provider}.{$key}");

        return is_scalar($value) ? (string) $value : null;
    }
}
