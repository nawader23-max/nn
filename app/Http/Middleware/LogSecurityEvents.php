<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Writes every authentication / authorisation rejection to the dedicated
 * `security` log channel (brute-force attempts, permission probing, CSRF
 * abuse, throttled endpoints, bridge signature rejections).
 *
 * The middleware only observes — it never alters the response.
 */
class LogSecurityEvents
{
    /** HTTP statuses that always deserve a security-trail entry. */
    private const WATCHED = [401, 403, 419, 429];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $status = $response->getStatusCode();

        if (! in_array($status, self::WATCHED, true)) {
            return $response;
        }

        try {
            $user = $request->user();

            Log::channel('security')->warning('security.rejection', [
                'status' => $status,
                'reason' => $this->reason($status),
                'method' => $request->method(),
                'path' => '/'.ltrim($request->path(), '/'),
                'route' => $request->route()?->getName(),
                'ip' => $request->ip(),
                'user_agent' => mb_substr((string) $request->userAgent(), 0, 180),
                'admin_id' => $user?->isAdmin() ? $user->getAuthIdentifier() : null,
                'user_id' => $user?->getAuthIdentifier(),
                'params' => $this->safeParams($request),
            ]);
        } catch (\Throwable) {
            // Never let telemetry break the response cycle.
        }

        return $response;
    }

    private function reason(int $status): string
    {
        return match ($status) {
            401 => 'unauthenticated',
            403 => 'forbidden',
            419 => 'session_expired_or_csrf',
            429 => 'rate_limited',
            default => 'other',
        };
    }

    private function safeParams(Request $request): array
    {
        return collect($request->route()?->parameters() ?? [])
            ->map(fn ($value) => is_scalar($value) ? $value : gettype($value))
            ->take(8)
            ->all();
    }
}
