<?php

return [
    'api_id'   => env('API_ID', ''),
    'api_hash' => env('API_HASH', ''),
    'token'    => env('API_TOKEN', ''),
    'channels'  => [
        [
            'slug'=> 'btc',
            'name' => '@bitcoin'
        ],
        [
            'slug'=> 'binance',
            'name' => '@binance_announcements'
        ],
        [
            'slug'=> 'news_crypto',
            'name' => '@news_crypto'
        ],
        [
            'slug'=> 'the_yescoin',
            'name' => '@theYescoin'
        ],

    ],
];