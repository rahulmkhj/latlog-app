<?php

namespace Latlog\Providers;

use Latlog\Events\PingRunEvent;
use Latlog\Listeners\PingResponseListener;
use Latlog\Events\TargetUpdateEvent;
use Latlog\Listeners\TargetUpdateListener;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        PingRunEvent::class =>  [
            PingResponseListener::class,
        ],
        TargetUpdateEvent::class => [
            TargetUpdateListener::class,
        ]
    ];
}
