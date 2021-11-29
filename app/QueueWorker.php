<?php

namespace App;

use App\Adapters\AbstractAdapter;
use App\Contracts\QueueWorkerInterface;

class QueueWorker implements QueueWorkerInterface
{
    protected AbstractAdapter $adapter;

    /**
     * @throws \Exception
     */
    public function __construct(AbstractAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @throws \Exception
     */
    public function push(string $queue, string $data)
    {
        $this->adapter->push($queue, $data);
    }

    /**
     * @throws \Exception
     */
    public function listen(string $queue, $closure)
    {
        $this->adapter->listen($queue, $closure);
    }
}
