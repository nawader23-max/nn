<?php

use App\Http\Middleware\AdminIpGuard;
use App\Http\Middleware\EnsureUserRole;
use App\Http\Middleware\HoneypotProtection;
use App\Http\Middleware\LogSecurityEvents;
use App\Http\Middleware\SecurityHeaders;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role'     => EnsureUserRole::class,
            'admin.ip' => AdminIpGuard::class,
            'honeypot' => HoneypotProtection::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'api/*',
        ]);

        // Only the local nginx is a trusted proxy (see travelsstar.net notes).
        $middleware->trustProxies(at: ['127.0.0.1', '::1'], headers: Request::HEADER_X_FORWARDED_FOR
            | Request::HEADER_X_FORWARDED_HOST
            | Request::HEADER_X_FORWARDED_PORT
            | Request::HEADER_X_FORWARDED_PROTO);

        // Baseline browser-hardening headers + security event trail.
        $middleware->web(append: [
            SecurityHeaders::class,
            LogSecurityEvents::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
