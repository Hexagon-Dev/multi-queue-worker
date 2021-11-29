<?php

namespace App\Adapters;

use App\Contracts\AdapterInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQAdapter extends AbstractAdapter implements AdapterInterface
{
    protected $engine;

    public function __construct()
    {
        $connection = new AMQPStreamConnection(
            config('adapter.adapters.rabbitmq.host'),
            config('adapter.adapters.rabbitmq.port'),
            config('adapter.adapters.rabbitmq.user'),
            config('adapter.adapters.rabbitmq.password'),
        );
        $this->engine = $connection->channel();
    }

    public function push($queue, $data)
    {
        $this->engine->basic_publish(new AMQPMessage($data), '', $queue);
    }

    /**
     * @throws \ErrorException
     */
    public function listen($queue, $closure)
    {
        $this->engine->queue_declare($queue, false, false, false, false);
        $this->engine->basic_consume($queue, '', false, true, false, false, $closure);
        while ($this->engine->is_open()) {
            $this->engine->wait();
        }
    }
}
