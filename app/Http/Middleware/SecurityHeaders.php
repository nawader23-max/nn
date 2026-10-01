<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Comprehensive browser-hardening headers for every web response.
 *
 * Covers OWASP Top-10 browser-side mitigations: HSTS with preload, CSP,
 * framing prevention, MIME sniffing, referrer leakage, and feature-policy
 * lockdown. HSTS is emitted only for secure requests so local/CLI contexts
 * stay untouched; the edge (nginx / Cloudflare) already sends it in production.
 */
class SecurityHeaders
{
    /**
     * Build a strict Content-Security-Policy.
     * Allows Google Fonts, Analytics, reCAPTCHA, and the platform bridge peer.
     */
    private function buildCsp(Request $request): string
    {
        $peerUrl = rtrim(config('platform.peer_url', 'https://travelsstar.net'), '/');

        $directives = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' https://www.googletagmanager.com https://www.google-analytics.com https://www.google.com https://www.gstatic.com https://t.contentsquare.net",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
            "font-src 'self' data: https://fonts.gstatic.com",
            "img-src 'self' data: blob: https://www.google-analytics.com https://www.googletagmanager.com",
            "connect-src 'self' https://www.google-analytics.com https://www.googletagmanager.com {$peerUrl}",
            "frame-src 'self' https://www.google.com",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "upgrade-insecure-requests",
        ];

        return implode('; ', $directives);
    }

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Do not apply to JSON/API responses - only HTML
        $contentType = $response->headers->get('Content-Type', '');
        $isHtml = str_contains($contentType, 'text/html') || $contentType === '';

        $headers = [
            'X-Content-Type-Options'            => 'nosniff',
            'X-Frame-Options'                   => 'SAMEORIGIN',
            'Referrer-Policy'                   => 'strict-origin-when-cross-origin',
            'Permissions-Policy'                => 'camera=(), microphone=(), geolocation=(), payment=(), usb=(), magnetometer=(), gyroscope=(), accelerometer=()',
            'Cross-Origin-Opener-Policy'        => 'same-origin',
            'Cross-Origin-Embedder-Policy'      => 'credentialless',
            'Cross-Origin-Resource-Policy'      => 'same-origin',
            'X-Permitted-Cross-Domain-Policies' => 'none',
            'X-XSS-Protection'                  => '1; mode=block',
            'X-DNS-Prefetch-Control'            => 'off',
            'X-Download-Options'                => 'noopen',
        ];

        if ($isHtml) {
            $headers['Content-Security-Policy'] = $this->buildCsp($request);
        }

        if ($request->isSecure()) {
            // HSTS with includeSubDomains and preload directive for
            // HSTS preload list eligibility (hstspreload.org).
            $headers['Strict-Transport-Security'] = 'max-age=63072000; includeSubDomains; preload';
        }

        foreach ($headers as $name => $value) {
            if (! $response->headers->has($name)) {
                $response->headers->set($name, $value);
            }
        }

        // Remove server identification headers to prevent fingerprinting
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        return $response;
    }
}
