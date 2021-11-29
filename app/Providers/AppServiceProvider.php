<?php

namespace App\Providers;

use App\Adapters\RabbitMQAdapter;
use App\Adapters\RedisAdapter;
use App\Contracts\QueueWorkerInterface;
use App\QueueWorker;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(QueueWorkerInterface::class, function () {
            $driver = config('adapter.default');

            switch ($driver) {
                case 'redis':
                    return new QueueWorker(new RedisAdapter());
                case 'rabbitmq':
                    return new QueueWorker(new RabbitMQAdapter());
                default:
                    throw new \Exception('QueueWorker ' . $driver .  ' not found');
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
