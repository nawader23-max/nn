<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Restrict admin-level routes to a whitelist of trusted IP addresses.
 *
 * When ADMIN_ALLOWED_IPS is empty (or unset) the guard is disabled and all
 * IPs are permitted — useful for local dev. In production, set it to a
 * comma-separated list of trusted IPs (e.g. office VPN, your home IP).
 *
 * Usage in routes:
 *     ->middleware('admin.ip')
 */
class AdminIpGuard
{
    public function handle(Request $request, Closure $next): Response
    {
        $allowedRaw = (string) config('security.admin_allowed_ips', '');

        // Guard disabled when no IPs configured
        if ($allowedRaw === '') {
            return $next($request);
        }

        $allowed = array_filter(array_map('trim', explode(',', $allowedRaw)));
        $clientIp = $request->ip();

        if (! in_array($clientIp, $allowed, true)) {
            Log::channel('security')->warning('admin.ip_blocked', [
                'ip'         => $clientIp,
                'path'       => '/' . ltrim($request->path(), '/'),
                'user_agent' => mb_substr((string) $request->userAgent(), 0, 180),
                'user_id'    => $request->user()?->getAuthIdentifier(),
            ]);

            abort(403, 'الوصول مقيد: عنوان IP الحالي غير مصرح له بالوصول لهذا القسم الإداري.');
        }

        return $next($request);
    }
}
