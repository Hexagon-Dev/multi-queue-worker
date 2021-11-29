<?php

namespace App\Http\Controllers;

use App\Contracts\QueueWorkerInterface;
use App\Http\Requests\UserCreateRequest;
use App\Jobs\SaveUserToDatabase;
use Illuminate\Http\Request;
use Redis;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function queue(Request $request, QueueWorkerInterface $queueWorker, $event)
    {
        $queueWorker->push($event, $request->input('data'));
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
