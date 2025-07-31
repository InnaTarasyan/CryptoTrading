<?php

// You can find the keys here : https://developer.twitter.com/en/portal/projects-and-apps

return [
    'debug' => env('APP_DEBUG', false),

    'api_url' => 'api.twitter.com',
    'upload_url' => 'upload.twitter.com',
    'api_version' => env('TWITTER_API_VERSION', '1.1'),

    'consumer_key' => env('TWITTER_CONSUMER_KEY'),
    'consumer_secret' => env('TWITTER_CONSUMER_SECRET'),
    'access_token' => env('TWITTER_ACCESS_TOKEN'),
    'access_token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET'),

    'authenticate_url' => 'https://api.twitter.com/oauth/authenticate',
    'access_token_url' => 'https://api.twitter.com/oauth/access_token',
    'request_token_url' => 'https://api.twitter.com/oauth/request_token',
    'bitcoin_id'           => env('TWITTER_BITCOIN_ID'),
    'eth_id'               => env('TWITTER_ETH_ID'),
    'coin_market_cap'      => env('TWITTER_COIN_MARKET_CAP'),
    'tesla'                => env('TWITTER_TESLA'),
    'coinbase'             => env('TWITTER_COINBASE'),
    'litecoin'             => env('TWITTER_LITECOIN'),
    'btctn'                => env('TWITTER_BTCTN'),
    'bitcoin_magazine'     => env('TWITTER_BITCOINMAGAZINE'),
    'shib'                 => env('TWITTER_SHIB'),

];
