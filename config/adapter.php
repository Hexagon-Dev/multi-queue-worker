<?php

return [
    'default' => env('COOL_ADAPTER_TYPE', 'redis'),

    'adapters' => [
        'redis' => [
            'host' => env('COOL_ADAPTER_HOST', 'redis'),
            'port' => env('COOL_ADAPTER_PORT', '6379'),
            'user' => env('COOL_ADAPTER_USER', ''),
            'password' => env('COOL_ADAPTER_PASSWORD', 'password'),
        ],
        'rabbitmq' => [
            'host' => env('COOL_ADAPTER_HOST', 'localhost'),
            'port' => env('COOL_ADAPTER_PORT', '5672'),
            'user' => env('COOL_ADAPTER_USER', 'guest'),
            'password' => env('COOL_ADAPTER_PASSWORD', 'guest'),
        ],
        'zhopa' => [
            'host' => env('COOL_ADAPTER_HOST', 'localhost'),
            'port' => env('COOL_ADAPTER_PORT', '65536'),
            'user' => env('COOL_ADAPTER_USER', ''),
            'password' => env('COOL_ADAPTER_PASSWORD', 'password'),
        ],
    ]
];
