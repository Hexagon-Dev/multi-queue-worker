<?php

namespace App\Contracts;

interface QueueManagerInterface
{
    /**
     * @return mixed
     */
    public static function init();

    /**
     * @param string $queue
     * @param string $data
     * @return mixed
     */
    public static function push(string $queue, string $data);

    /**
     * @param string $queue
     * @param $closure
     * @return mixed
     */
    public static function listen(string $queue, $closure);
}
