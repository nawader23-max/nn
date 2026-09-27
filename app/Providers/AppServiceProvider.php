<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerRateLimiters();
    }

    /**
     * Named rate limiters for the public-facing security surfaces.
     */
    private function registerRateLimiters(): void
    {
        RateLimiter::for('login', fn (Request $request) => [
            Limit::perMinute(5)->by('ip:'.$request->ip()),
            Limit::perMinute(15)->by('id:'.Str::lower((string) $request->input('email')).'|'.$request->ip()),
        ]);

        RateLimiter::for('register', fn (Request $request) => Limit::perMinute(5)->by($request->ip()));

        RateLimiter::for('password-reset', fn (Request $request) => Limit::perMinute(3)->by($request->ip()));

        RateLimiter::for('contact', fn (Request $request) => Limit::perMinute(6)->by($request->ip()));

        RateLimiter::for('public-api', fn (Request $request) => Limit::perMinute(60)->by($request->ip()));

        RateLimiter::for('bridge-api', fn (Request $request) => Limit::perMinute(180)->by($request->ip()));

        RateLimiter::for('reverse-otp-generate', function (Request $request) {
            $phone = preg_replace('/\D+/', '', (string) $request->input('phone')) ?? '';
            if (str_starts_with($phone, '00')) {
                $phone = substr($phone, 2);
            } elseif (str_starts_with($phone, '0')) {
                $phone = (string) config('reverse_otp.default_country_code').substr($phone, 1);
            }

            return [
                Limit::perMinutes(10, 5)->by('reverse-otp:ip:'.$request->ip()),
                Limit::perMinutes(10, 5)->by('reverse-otp:phone:'.hash('sha256', $phone)),
            ];
        });

        RateLimiter::for('reverse-otp-status', fn (Request $request) => Limit::perMinute(60)->by('reverse-otp:status:'.$request->ip()));
    }
}
