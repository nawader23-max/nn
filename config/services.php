<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services & Sovereign Integrations
    |--------------------------------------------------------------------------
    | All engines stand ready on their corresponding API keys.
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'me-central-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // ── Payment Gateways ──────────────────────────────────────────────────
    'moyasar' => [
        'publishable_key' => env('MOYASAR_PUBLISHABLE_KEY'),
        'secret_key' => env('MOYASAR_SECRET_KEY'),
    ],

    'stripe' => [
        'publishable_key' => env('STRIPE_KEY'),
        'secret_key' => env('STRIPE_SECRET'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
    ],

    'apple_pay' => [
        'merchant_id' => env('APPLE_PAY_MERCHANT_ID', 'merchant.com.nawadersrv.sovereign'),
        'cert_path' => env('APPLE_PAY_CERT_PATH'),
    ],

    'tamara' => [
        'api_token' => env('TAMARA_API_TOKEN'),
        'notification_token' => env('TAMARA_NOTIFICATION_TOKEN'),
        'api_url' => env('TAMARA_API_URL', 'https://api.tamara.co'),
    ],

    'tabby' => [
        'public_key' => env('TABBY_PUBLIC_KEY'),
        'secret_key' => env('TABBY_SECRET_KEY'),
        'merchant_code' => env('TABBY_MERCHANT_CODE'),
    ],

    // ── AI Models & Agents ────────────────────────────────────────────────
    'allam' => [
        'api_key' => env('ALLAM_API_KEY'),
        'endpoint' => env('ALLAM_ENDPOINT', 'https://api.allam.sdaia.gov.sa/v1/chat'),
    ],

    'openai' => [
        'api_key' => env('OPENAI_API_KEY'),
        'org_id' => env('OPENAI_ORG_ID'),
    ],

    'anthropic' => [
        'api_key' => env('ANTHROPIC_API_KEY'),
    ],

    'gemini' => [
        'api_key' => env('GEMINI_API_KEY'),
    ],

    'deepseek' => [
        'api_key' => env('DEEPSEEK_API_KEY'),
    ],

    'ollama' => [
        'endpoint' => env('OLLAMA_ENDPOINT', 'http://localhost:11434'),
        'model' => env('OLLAMA_MODEL', 'llama3'),
    ],

    // ── Government & Ministerial ──────────────────────────────────────────
    'nafath' => [
        'app_id' => env('NAFATH_APP_ID'),
        'app_key' => env('NAFATH_APP_KEY'),
    ],

    'wathq' => [
        'api_key' => env('WATHQ_API_KEY'),
    ],

    'zatca' => [
        'csid' => env('ZATCA_CSID'),
        'secret' => env('ZATCA_SECRET'),
        'binary_token' => env('ZATCA_BINARY_TOKEN'),
    ],

    'delaware' => [
        'api_key' => env('DELAWARE_API_KEY'),
        'agent_code' => env('DELAWARE_AGENT_CODE'),
    ],

    // ── Communications ────────────────────────────────────────────────────
    'whatsapp' => [
        'phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID'),
        'access_token' => env('WHATSAPP_ACCESS_TOKEN'),
        'webhook_verify_token' => env('WHATSAPP_VERIFY_TOKEN'),
    ],

    'sms' => [
        'api_key' => env('SMS_API_KEY'),
        'sender_name' => env('SMS_SENDER_NAME', 'NAWADER'),
    ],

    // ── Analytics & Compliance ────────────────────────────────────────────
    'ga4' => [
        'measurement_id' => env('GA4_MEASUREMENT_ID'),
    ],

    'contentsquare' => [
        'project_id' => env('CONTENTSQUARE_PROJECT_ID'),
    ],

    'cookieyes' => [
        'website_key' => env('COOKIEYES_WEBSITE_KEY'),
    ],

    'recaptcha' => [
        'site_key' => env('RECAPTCHA_SITE_KEY'),
        'secret_key' => env('RECAPTCHA_SECRET_KEY'),
    ],

];
