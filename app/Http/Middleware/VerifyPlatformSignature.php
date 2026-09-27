<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

/**
 * Guards the signed server-to-server bridge (Nawader ⇄ TravelsStar).
 *
 * Required headers:
 *   X-Platform-Id         — identity of the calling platform
 *   X-Platform-Timestamp  — unix timestamp (seconds)
 *   X-Platform-Nonce      — unique random string per request (replay guard)
 *   X-Platform-Signature  — HMAC-SHA256 of the canonical request string
 *
 * Canonical string (identical on both applications):
 *   METHOD \n /path \n timestamp \n nonce \n sha256(raw body)
 */
class VerifyPlatformSignature
{
    public function handle(Request $request, Closure $next): Response
    {
        $secret = (string) config('platform.secret');

        if ($secret === '') {
            return response()->json([
                'error' => 'Platform bridge is not configured (PLATFORM_SYNC_SECRET is empty).',
            ], 503);
        }

        $signature = (string) $request->header('X-Platform-Signature', '');
        $timestamp = (string) $request->header('X-Platform-Timestamp', '');
        $nonce = (string) $request->header('X-Platform-Nonce', '');
        $peerId = (string) $request->header('X-Platform-Id', '');

        if ($signature === '' || $timestamp === '' || strlen($nonce) < 8) {
            return response()->json(['error' => 'Missing bridge signature headers.'], 401);
        }

        if (! ctype_digit($timestamp)) {
            return response()->json(['error' => 'Malformed bridge timestamp.'], 401);
        }

        $skew = (int) config('platform.skew', 300);

        if (abs(now()->getTimestamp() - (int) $timestamp) > $skew) {
            return response()->json(['error' => 'Bridge signature has expired.'], 401);
        }

        $expected = self::sign(
            $request->method(),
            $request->path(),
            $timestamp,
            $nonce,
            $request->getContent(),
            $secret,
        );

        if (! hash_equals($expected, $signature)) {
            return response()->json(['error' => 'Invalid bridge signature.'], 401);
        }

        // Replay protection — a nonce may only be used once inside the skew window.
        $nonceKey = 'bridge:nonce:'.($peerId !== '' ? $peerId.':' : '').$nonce;

        if (! Cache::add($nonceKey, true, $skew * 2)) {
            return response()->json(['error' => 'Duplicate bridge nonce (replay detected).'], 401);
        }

        $request->attributes->set('platform_bridge_id', $peerId);

        return $next($request);
    }

    /**
     * Canonical signing routine — shared by the middleware and the outbound client.
     */
    public static function sign(
        string $method,
        string $path,
        string $timestamp,
        string $nonce,
        string $body,
        string $secret,
    ): string {
        $canonical = implode("\n", [
            strtoupper($method),
            '/'.ltrim($path, '/'),
            $timestamp,
            $nonce,
            hash('sha256', $body),
        ]);

        return hash_hmac('sha256', $canonical, $secret);
    }
}
