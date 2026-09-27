<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ContentBlockService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Inbound half of the signed bridge between Nawader (main platform) and
 * TravelsStar (admin hub).
 *
 *   GET  /api/bridge/v1/ping             identity handshake (public)
 *   GET  /api/bridge/v1/content/blocks   local page content (public read)
 *   POST /api/bridge/v1/content/sync     signed ingest → ContentBlockService store
 *   POST /api/bridge/v1/events           signed platform event receiver
 *
 * Accepted sync shapes:
 *   { "page": "home", "fields": { "hero_title": "…" } }
 *   { "blocks": [ { "key": "x", "payload": { "page": "home", "fields": {…} } } ] }
 *   { "blocks": [ { "key": "x", "value":   { "page": "home", "fields": {…} } } ] }
 */
class BridgeController extends Controller
{
    /**
     * Identity handshake — never exposes secrets.
     */
    public function ping(): JsonResponse
    {
        return response()->json([
            'status' => 'operational',
            'platform' => (string) config('platform.id'),
            'app' => config('app.name'),
            'url' => config('app.url'),
            'environment' => app()->environment(),
            'bridge' => config('platform.prefix'),
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    /**
     * Public read of the local page-content store (marketing copy only).
     */
    public function blocks(): JsonResponse
    {
        return response()->json([
            'platform' => (string) config('platform.id'),
            'data' => ContentBlockService::getAll(),
            'generated' => now()->toIso8601String(),
        ]);
    }

    /**
     * Signed ingest — merges pushed fields into the main platform page store.
     */
    public function sync(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'page' => ['nullable', 'string', 'max:60', 'regex:/^[a-z0-9_\-\.]+$/'],
            'fields' => ['nullable', 'array'],
            'blocks' => ['nullable', 'array'],
            'blocks.*.key' => ['nullable', 'string'],
            'blocks.*.payload' => ['nullable', 'array'],
            'blocks.*.value' => ['nullable', 'array'],
        ]);

        $applied = [];

        if (! empty($validated['page']) && ! empty($validated['fields'])) {
            $this->apply($validated['page'], $validated['fields'], $applied);
        }

        foreach ($validated['blocks'] ?? [] as $block) {
            $payload = $block['payload'] ?? $block['value'] ?? null;

            if (! is_array($payload) || empty($payload['page']) || empty($payload['fields'])) {
                continue;
            }

            $page = (string) $payload['page'];

            if (! preg_match('/^[a-z0-9_\-\.]+$/', $page)) {
                continue;
            }

            $this->apply($page, (array) $payload['fields'], $applied);
        }

        if ($applied === []) {
            return response()->json([
                'error' => 'No applicable content found. Send {"page","fields"} or blocks carrying {"page","fields"}.',
            ], 422);
        }

        Log::info('Platform bridge: content applied to page store', [
            'origin' => $request->attributes->get('platform_bridge_id'),
            'pages' => $applied,
        ]);

        return response()->json([
            'applied' => $applied,
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    /**
     * Signed platform events (webhooks) — recorded and acknowledged.
     */
    public function events(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'event' => ['required', 'string', 'max:120'],
            'payload' => ['array'],
        ]);

        Log::info('Platform bridge: event received', [
            'origin' => $request->attributes->get('platform_bridge_id'),
            'event' => $validated['event'],
            'payload' => $validated['payload'] ?? [],
        ]);

        return response()->json([
            'received' => true,
            'event' => $validated['event'],
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    /**
     * Normalise pushed values to scalars and persist them through the page store.
     */
    protected function apply(string $page, array $fields, array &$applied): void
    {
        $clean = [];

        foreach ($fields as $key => $value) {
            if (! is_string($key) || $key === '') {
                continue;
            }

            if (is_array($value)) {
                $value = $value['value'] ?? json_encode($value, JSON_UNESCAPED_UNICODE);
            }

            if (is_scalar($value) || $value === null) {
                $clean[$key] = is_bool($value) ? ($value ? '1' : '0') : (string) $value;
            }
        }

        if ($clean === []) {
            return;
        }

        ContentBlockService::savePageBlocks($page, $clean);

        $applied[$page] = ($applied[$page] ?? 0) + count($clean);
    }
}
