<?php

namespace Latlog\Core;

use Latlog\Providers\AppServiceProvider;
use Latlog\Providers\EventServiceProvider;

class Application extends \Laravel\Lumen\Application
{
    public function loadConfigurationFiles()
    {
        $this->configure('app');
        $this->configure('latlog');
    }

    public function registerMiddlewares()
    {
        $this->registerGlobalMiddlewares();
        $this->registerRouteMiddlewares();
    }

    protected function registerGlobalMiddlewares()
    {

    }

    protected function registerRouteMiddlewares()
    {

    }

    public function registerServiceProviders()
    {
        $this->register(AppServiceProvider::class);
        $this->register(EventServiceProvider::class);
    }

    public function registerRoutes()
    {

    }




}
