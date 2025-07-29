<?php

return [
    'api_id'   => env('API_ID', ''),
    'api_hash' => env('API_HASH', ''),
    'channels'  => [
        [
            'slug'=> 'btc',
            'name' => '@bitcoin'
        ],
    ],
];