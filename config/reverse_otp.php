<?php

return [
    'enabled' => env('REVERSE_OTP_ENABLED', false),
    'cache_store' => env('REVERSE_OTP_CACHE_STORE', 'redis'),
    'ttl_seconds' => 180,
    'prefix' => 'NAWADER',
    'default_country_code' => env('REVERSE_OTP_DEFAULT_COUNTRY_CODE', '966'),
    'whatsapp_number' => env('REVERSE_OTP_WHATSAPP_NUMBER'),
    'sms_number' => env('REVERSE_OTP_SMS_NUMBER'),
    'listener_secret' => env('REVERSE_OTP_LISTENER_SECRET'),
    'listener_url' => env('REVERSE_OTP_LISTENER_URL', 'http://127.0.0.1:3871'),
    'privileged_roles' => ['super_admin', 'sovereign_advisor', 'developer'],
];
