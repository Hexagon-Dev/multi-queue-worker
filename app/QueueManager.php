<?php

namespace App;

use Redis;

class QueueManager
{
    public Redis $redis;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('redis', 6379);
        $this->redis->auth('password');
    }

    /**
     * @throws \JsonException
     */
    public function push(string $queue, string $data)
    {
        $this->redis->rpush($queue, $data);
    }

    public function pop(string $queue)
    {
        return $this->redis->lpop($queue);
    }

    public function listen(string $queue, $closure)
    {
        while (true) {
            $data = $this->pop($queue);
            if ($data) {
                $closure($data);
            }
        }
    }
}
