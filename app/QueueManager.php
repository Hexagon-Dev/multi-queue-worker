<?php

namespace App;

use App\Contracts\QueueManagerInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Redis;

class QueueManager implements QueueManagerInterface
{
    public $adapter;

    public function __construct()
    {
        switch (config('adapter.default')) {
            case 'redis':
                $this->adapter = new Redis();
                $this->adapter->connect(config('adapter.redis.host'), config('adapter.redis.port'));
                $this->adapter->auth(config('adapter.redis.password'));
                break;
            case 'rabbitmq':
                $connection = new AMQPStreamConnection(
                    config('adapter.rabbitmq.host'),
                    config('adapter.rabbitmq.port'),
                    config('adapter.rabbitmq.user'),
                    config('adapter.rabbitmq.password'),
                );
                $this->adapter = $connection->channel();
                break;
        }
    }

    public function push(string $queue, string $data): void
    {
        $this->adapter->rpush($queue, $data);

        $this->adapter->basic_publish(new AMQPMessage($data), '', $queue);
    }

    public function pop(string $queue)
    {
        switch (config('adapter.default')) {
            case 'redis':
                return $this->adapter->lpop($queue);
            case 'rabbitmq':
                $callback = function ($msg) {
                    echo ' [x] Received ', $msg->body, "\n";
                };
                return $this->adapter->basic_consume($queue, '', false, false, false, false, $callback);
        }
    }

    public function listen(string $queue, $closure): void
    {
        while (true) {
            $data = $this->pop($queue);
            if ($data) {
                $closure($data);
            }
        }
    }
}
