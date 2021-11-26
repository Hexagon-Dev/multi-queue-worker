<?php

namespace App;

use App\Contracts\QueueManagerInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Redis;

class QueueManager implements QueueManagerInterface
{
    public static function init()
    {
        switch (config('adapter.default')) {
            case 'redis':
                $adapter = new Redis();
                $adapter->connect(config('adapter.adapters.redis.host'), config('adapter.adapters.redis.port'));
                $adapter->auth(config('adapter.adapters.redis.password'));
                return $adapter;
            case 'rabbitmq':
                $connection = new AMQPStreamConnection(
                    config('adapter.adapters.rabbitmq.host'),
                    config('adapter.adapters.rabbitmq.port'),
                    config('adapter.adapters.rabbitmq.user'),
                    config('adapter.adapters.rabbitmq.password'),
                );
                return $connection->channel();
        }
        return null;
    }

    public static function push(string $queue, string $data)
    {
        if (! $adapter = self::init()) {
            return null;
        }
        switch (config('adapter.default')) {
            case 'redis':
                $adapter->rpush($queue, $data);
                break;
            case 'rabbitmq':
                $adapter->basic_publish(new AMQPMessage($data), '', $queue);
                break;
        }
    }

    public static function listen(string $queue, $closure)
    {
        if (! $adapter = self::init()) {
            return null;
        }
        while (true) {
            switch (config('adapter.default')) {
                case 'redis':
                    $data = $adapter->lpop($queue);
                    break;
                case 'rabbitmq':
                    return $adapter->basic_consume($queue, '', false, false, false, false, $closure);
                default:
                    $data = null;
            }
            if ($data) {
                $closure($data);
            }
        }
    }
}
