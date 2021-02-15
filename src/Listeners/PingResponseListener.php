<?php

namespace Latlog\Listeners;

use Latlog\Events\PingRunEvent;
use Latlog\Library\PingResponse;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PingResponseListener
{
    protected $response;

    protected $exitCode;

    protected $measurement;

    /**
     * @param PingRunEvent $event
     */
    public function handle(PingRunEvent $event)
    {
        $this->measurement = $event->target->measurements()->create();
        $that = $this;
        $event->process->stdout->on('data', function( $chunk ) use( $event, $that ){
           $that->response =  PingResponse::parseFromRaw($chunk);
        });

        $event->process->on('exit', function( $exitCode ) use( $that ){
            $that->measurement->exitcode = $exitCode;
            if( $exitCode == 0 ):
                $that->measurement->fill([
                    'min'           =>  $that->response->min,
                    'max'           =>  $that->response->max,
                    'avg'           =>  $that->response->avg,
                    'stddev'        =>  $that->response->stddev,
                    'lostPercent'   =>  $that->response->lostPercent,
                ]);
            endif;
            $that->measurement->save();
        });

    }
}
