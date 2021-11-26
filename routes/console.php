<?php

use App\QueueManager;
use Illuminate\Foundation\Inspiring;
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

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('coolworker', function () {
    $this->comment('CoolWorker 3000 started, waiting for events...');
    $manager = new QueueManager();

    $manager->listen('log data', function($data) {
        Log::info($data);
        $this->comment('Log event executed. Outputting ' . $data . ' to console.');
    });
});
