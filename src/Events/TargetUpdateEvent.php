<?php


namespace Latlog\Events;


class TargetUpdateEvent extends Event
{
    public $targetId;

    public function __construct( int  $targetId )
    {
        $this->targetId = $targetId;
    }
}
