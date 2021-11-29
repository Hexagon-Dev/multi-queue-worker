<?php

namespace App\Adapters;

use App\Contracts\AdapterInterface;
use Redis;

class RedisAdapter extends AbstractAdapter implements AdapterInterface
{
    protected Redis $engine;

    public function __construct()
    {
        $this->engine = new Redis();
        $this->engine->connect(config('adapter.adapters.redis.host'), config('adapter.adapters.redis.port'));
        $this->engine->auth(config('adapter.adapters.redis.password'));
    }

    public function push($queue, $data)
    {
        $this->engine->rpush($queue, $data);
    }

    public function listen($queue, $closure)
    {
        while (true) {
            if ($data = $this->engine->lpop($queue)) {
                $closure($data);
            }
        }
    }
}
