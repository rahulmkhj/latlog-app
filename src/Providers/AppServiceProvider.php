<?php

namespace Latlog\Providers;

use Illuminate\Console\OutputStyle;
use Illuminate\Support\ServiceProvider;
use React\EventLoop\Factory;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;

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

        $this->app->singleton('console.output', function(){
            return new OutputStyle(
                new StringInput(''),
                new StreamOutput(fopen('php://stdout', 'w'))
            );
        });
    }
}
