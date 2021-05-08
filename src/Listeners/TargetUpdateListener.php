<?php


namespace Latlog\Listeners;

use Latlog\Core\Debugger\Debug;
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
            Debug::info("Found host: {$target->host} with target id: {$target->id}");
            Scheduler::start($target);
        else:
            if( Scheduler::isRunning( $event->targetId) ):
                Debug::info("Target with ID: {$event->targetId} seems to be have removed. Stopping..");
                Scheduler::stop( $event->targetId );
            endif;
        endif;
    }

}
