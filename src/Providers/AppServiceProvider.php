<?php

namespace Latlog\Providers;

use Illuminate\Support\ServiceProvider;
use React\EventLoop\Factory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadMigrations();
        $this->registerObjects();
    }

    protected function loadMigrations()
    {
        $this->loadMigrationsFrom( __DIR__ . '/../Database/Migrations');
    }

    protected function registerObjects()
    {
        $this->app->singleton('loop', function(){
            return Factory::create();
        });
    }
}
