<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Honeypot anti-bot protection for public-facing forms.
 *
 * Adds an invisible form field that humans never fill in. If a bot
 * auto-fills it, the request is silently rejected with a 422.
 *
 * Configuration via .env:
 *   HONEYPOT_ENABLED=true
 *   HONEYPOT_FIELD_NAME=sovereign_token_verify
 *
 * In Blade forms, add the hidden field:
 *   <x-honeypot />
 *
 * Usage in routes:
 *   ->middleware('honeypot')
 */
class HoneypotProtection
{
    public function handle(Request $request, Closure $next): Response
    {
        // Only check POST/PUT/PATCH requests
        if (! in_array($request->method(), ['POST', 'PUT', 'PATCH'])) {
            return $next($request);
        }

        if (! config('security.honeypot_enabled', true)) {
            return $next($request);
        }

        $fieldName = config('security.honeypot_field_name', 'sovereign_token_verify');
        $value = $request->input($fieldName);

        // If the honeypot field is filled, it's a bot
        if ($value !== null && $value !== '') {
            Log::channel('security')->warning('honeypot.bot_detected', [
                'ip'         => $request->ip(),
                'path'       => '/' . ltrim($request->path(), '/'),
                'user_agent' => mb_substr((string) $request->userAgent(), 0, 180),
                'field'      => $fieldName,
            ]);

            // Return a realistic-looking response to confuse the bot
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'تم الإرسال بنجاح.',
                ], 200);
            }

            return back()->with('success', 'تم الإرسال بنجاح.');
        }

        return $next($request);
    }
}
