<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Redis;

class SaveUserToDatabase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $redis = new Redis();
            $redis->connect('redis', 6379);
            $redis->auth('password');

            $data = $redis->lpop('users');
            $data = json_decode($data, true);

            if (isset($data)) {
                User::query()->insert($data);
                Log::info('[Job] User created successfully.');
            } else {
                Log::error('[Job] User was not found in Redis.');
            }

        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
