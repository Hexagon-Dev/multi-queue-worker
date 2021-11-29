<?php

return [
    'default' => 'rabbitmq',

    'adapters' => [
        'redis' => [
            'className' => \App\Adapters\RedisAdapter::class,
            'host' => 'redis',
            'port' => '6379',
            'user' => '',
            'password' => 'password',
        ],
        'rabbitmq' => [
            'className' => \App\Adapters\RabbitMQAdapter::class,
            'host' => 'rabbitmq',
            'port' => '5672',
            'user' => 'guest',
            'password' => 'guest',
        ],
        'zhopa' => [
            'host' => 'localhost',
            'port' => '65536',
            'user' => '',
            'password' => 'password',
        ],
    ]
];
