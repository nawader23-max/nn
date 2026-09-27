<?php

/*
|--------------------------------------------------------------------------
| Sovereign Platform Bridge
|--------------------------------------------------------------------------
| Shared-secret configuration for the signed server-to-server bridge
| between Nawader (main platform) and TravelsStar (admin hub).
|
|   PLATFORM_ID            — identity of THIS application.
|   PLATFORM_PEER_URL      — base URL of the sibling platform.
|   PLATFORM_SYNC_SECRET   — shared HMAC secret (identical on both apps).
|   PLATFORM_SKEW         — allowed clock drift (seconds) for signatures.
|   PLATFORM_TIMEOUT      — outbound HTTP timeout (seconds).
*/

return [

    'id' => env('PLATFORM_ID', 'nawadersrv.com'),

    'peer_url' => rtrim((string) env('PLATFORM_PEER_URL', ''), '/'),

    'secret' => env('PLATFORM_SYNC_SECRET', ''),

    'skew' => (int) env('PLATFORM_SKEW', 300),

    'timeout' => (int) env('PLATFORM_TIMEOUT', 15),

    // Bridge namespace (must stay in sync on both applications).
    'prefix' => 'api/bridge/v1',

];
