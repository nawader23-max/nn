<?php

namespace App\Console\Commands;

use App\Services\ContentBlockService;
use App\Services\PlatformBridge;
use Illuminate\Console\Command;
use Throwable;

class BridgePullBlocks extends Command
{
    protected $signature = 'bridge:pull-blocks {--save : Persist payloads that carry {"page","fields"} into the local page store}';

    protected $description = 'Fetch signed content blocks from the hub platform (TravelsStar)';

    public function handle(PlatformBridge $bridge): int
    {
        if (! $bridge->isConfigured()) {
            $this->error('Bridge is not configured. Set PLATFORM_SYNC_SECRET and PLATFORM_PEER_URL in .env');

            return self::FAILURE;
        }

        try {
            $blocks = $bridge->fetchBlocks();
        } catch (Throwable $e) {
            $this->error('Fetch failed: '.$e->getMessage());

            return self::FAILURE;
        }

        if ($blocks === []) {
            $this->warn('The peer returned no blocks.');

            return self::SUCCESS;
        }

        $rows = [];
        $saved = 0;

        foreach ($blocks as $block) {
            $payload = $block['payload'] ?? [];
            $page = is_array($payload) ? ($payload['page'] ?? null) : null;
            $fields = is_array($payload) ? ($payload['fields'] ?? null) : null;

            $rows[] = [$block['key'] ?? '?', $page ?: '—', is_array($fields) ? count($fields) : 0];

            if ($this->option('save') && $page && is_array($fields)) {
                ContentBlockService::savePageBlocks((string) $page, $fields);
                $saved += count($fields);
            }
        }

        $this->table(['Block key', 'Target page', 'Fields'], $rows);

        if ($this->option('save')) {
            $this->info("Saved {$saved} field(s) into the local page store.");
        } else {
            $this->line('Dry run — re-run with <info>--save</info> to persist page payloads.');
        }

        return self::SUCCESS;
    }
}
