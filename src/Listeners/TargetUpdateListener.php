<?php


namespace Latlog\Listeners;

use Latlog\Events\TargetUpdateEvent;
use Latlog\Library\Scheduler;
use Latlog\Models\Target;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Exception;


class TargetUpdateListener
{

    /**
     * @param TargetUpdateEvent $event
     * @throws Exception
     */
    public function handle( TargetUpdateEvent $event )
    {
        if( $target = Target::find( $event->targetId ) ):
            Scheduler::start($target);
        else:
            if( Scheduler::isRunning( $event->targetId) )
                Scheduler::stop( $event->targetId );
        endif;
    }

}
