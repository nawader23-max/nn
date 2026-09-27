<?php

namespace App\Console\Commands;

use App\Services\PlatformBridge;
use Illuminate\Console\Command;
use Throwable;

class BridgePing extends Command
{
    protected $signature = 'bridge:ping';

    protected $description = 'Perform a signed handshake with the sibling platform (PLATFORM_PEER_URL)';

    public function handle(PlatformBridge $bridge): int
    {
        if (! $bridge->isConfigured()) {
            $this->error('Bridge is not configured. Set PLATFORM_SYNC_SECRET and PLATFORM_PEER_URL in .env');

            return self::FAILURE;
        }

        $this->line('Peer: <info>'.config('platform.peer_url').'</info>');

        try {
            $response = $bridge->ping();
        } catch (Throwable $e) {
            $this->error('Handshake failed: '.$e->getMessage());

            return self::FAILURE;
        }

        $this->table(['Field', 'Value'], collect($response)
            ->map(fn ($value, $key): array => [$key, is_scalar($value) ? (string) $value : json_encode($value, JSON_UNESCAPED_UNICODE)])
            ->values()
            ->all());

        return self::SUCCESS;
    }
}
