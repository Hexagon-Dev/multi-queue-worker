<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Jobs\SaveUserToDatabase;
use App\QueueManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Redis;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function job()
    {
        $manager = new QueueManager();

        $manager->listen('log data', function($data) {
            Log::info($data);
        });
    }

    public function queue(Request $request, $event)
    {
        $manager = new QueueManager();

        $manager->push($event, $request->input('data'));
    }

    public function create(UserCreateRequest $request)
    {
        try {
            $redis = new Redis();
            $redis->connect('redis', 6379);
            $redis->auth('password');

            $data = $request->validated();

            $redis->rpush("users", json_encode($data));

            SaveUserToDatabase::dispatchAfterResponse();

            return response()->json("User details accepted successfully.", Response::HTTP_CREATED);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
