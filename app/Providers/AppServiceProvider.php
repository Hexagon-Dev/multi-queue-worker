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
            $engine = config('adapter.adapters.' . config('adapter.default') . '.className');
            return new QueueWorker(new $engine);
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
