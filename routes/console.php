<?php

use App\Adapters\RedisAdapter;
use App\Adapters\RabbitMQAdapter;
use App\Contracts\QueueWorkerInterface;
use App\QueueWorker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('coolworker', function (QueueWorkerInterface $queueWorker) {
    $this->comment('CoolWorker 3000 started, waiting for events...');

    $queueWorker->listen('log data', function($data) {
        if (!is_string($data)) {
            $data = $data->body;
        }
            Log::info($data);
            $this->comment('Log event executed. Outputting ' . $data . ' to console.');
    });
});
