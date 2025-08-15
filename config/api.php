<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options for external API calls
    | including SSL verification settings and timeout values.
    |
    */

    'cryptics_tech' => [
        'base_url' => env('CRYPTICS_TECH_BASE_URL', 'https://devapi.cryptics.tech'),
        'endpoint' => '/daily_fcast',
        'timeout' => env('CRYPTICS_TECH_TIMEOUT', 10),
        'ssl_verify' => env('CRYPTICS_TECH_SSL_VERIFY', false),
        'fallback_to_http' => env('CRYPTICS_TECH_FALLBACK_HTTP', true),
        'use_demo_data' => env('CRYPTICS_TECH_USE_DEMO_DATA', true),
    ],

    'coinpaprika' => [
        'base_url' => env('COINPAPRIKA_BASE_URL', 'https://api.coinpaprika.com'),
        'endpoint' => '/v1/coins',
        'timeout' => env('COINPAPRIKA_TIMEOUT', 10),
        'ssl_verify' => env('COINPAPRIKA_SSL_VERIFY', true),
    ],

    'coingecko' => [
        'base_url' => env('COINGECKO_BASE_URL', 'https://api.coingecko.com'),
        'timeout' => env('COINGECKO_TIMEOUT', 10),
        'ssl_verify' => env('COINGECKO_SSL_VERIFY', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Global API Settings
    |--------------------------------------------------------------------------
    |
    | These settings apply to all API calls unless overridden
    | by specific API configurations above.
    |
    */

    'global' => [
        'default_timeout' => env('API_DEFAULT_TIMEOUT', 10),
        'default_ssl_verify' => env('API_DEFAULT_SSL_VERIFY', true),
        'retry_attempts' => env('API_RETRY_ATTEMPTS', 2),
        'retry_delay' => env('API_RETRY_DELAY', 1000), // milliseconds
    ],
]; 