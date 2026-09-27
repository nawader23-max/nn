<?php

namespace App\Services;

use App\Http\Middleware\VerifyPlatformSignature;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Outbound half of the signed bridge between Nawader (main platform) and
 * TravelsStar (admin hub).
 *
 * Every request is signed with the shared PLATFORM_SYNC_SECRET using the same
 * canonical string as App\Http\Middleware\VerifyPlatformSignature.
 */
class PlatformBridge
{
    public function isConfigured(): bool
    {
        return config('platform.secret') !== '' && config('platform.peer_url') !== '';
    }

    /**
     * Signed HTTP client pointed at the peer platform.
     */
    protected function signRequest(PendingRequest $request, string $method, string $path, string $body): PendingRequest
    {
        $timestamp = (string) now()->getTimestamp();
        $nonce = Str::random(32);
        $secret = (string) config('platform.secret');

        $signature = VerifyPlatformSignature::sign($method, $path, $timestamp, $nonce, $body, $secret);

        return $request
            ->withHeaders([
                'X-Platform-Id' => (string) config('platform.id'),
                'X-Platform-Timestamp' => $timestamp,
                'X-Platform-Nonce' => $nonce,
                'X-Platform-Signature' => $signature,
                'Accept' => 'application/json',
            ])
            ->timeout((int) config('platform.timeout', 15));
    }

    protected function endpoint(string $path): string
    {
        $base = (string) config('platform.peer_url');

        if ($base === '') {
            throw new RuntimeException('PLATFORM_PEER_URL is not configured.');
        }

        return $base.'/'.trim((string) config('platform.prefix'), '/').'/'.ltrim($path, '/');
    }

    protected function relativePath(string $path): string
    {
        return trim((string) config('platform.prefix'), '/').'/'.ltrim($path, '/');
    }

    /**
     * GET — identity handshake with the peer platform.
     */
    public function ping(): array
    {
        return $this->get('ping')->throw()->json();
    }

    /**
     * GET — fetch the peer's published content blocks.
     */
    public function fetchBlocks(): array
    {
        return $this->get('content/blocks')->throw()->json('data', []);
    }

    /**
     * POST — push page fields to the peer platform.
     */
    public function pushPage(string $page, array $fields): array
    {
        return $this->post('content/sync', ['page' => $page, 'fields' => $fields])->throw()->json();
    }

    /**
     * POST — deliver a signed platform event (webhook) to the peer.
     */
    public function dispatch(string $event, array $payload = []): array
    {
        return $this->post('events', ['event' => $event, 'payload' => $payload])->throw()->json();
    }

    protected function get(string $path)
    {
        return $this->signRequest(Http::acceptJson(), 'GET', $this->relativePath($path), '')
            ->get($this->endpoint($path));
    }

    protected function post(string $path, array $payload)
    {
        $body = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '{}';

        return $this->signRequest(Http::acceptJson()->withBody($body, 'application/json'), 'POST', $this->relativePath($path), $body)
            ->post($this->endpoint($path), $payload);
    }
}
