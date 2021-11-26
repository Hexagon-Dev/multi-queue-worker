<?php

namespace App\Contracts;

interface QueueManagerInterface
{
    /**
     * @param string $queue
     * @param string $data
     * @return mixed
     */
    public function push(string $queue, string $data);

    /**
     * @param string $queue
     * @return mixed
     */
    public function pop(string $queue);

    /**
     * @param string $queue
     * @param $closure
     * @return mixed
     */
    public function listen(string $queue, $closure);
}
