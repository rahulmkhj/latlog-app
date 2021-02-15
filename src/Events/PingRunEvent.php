<?php

namespace Latlog\Events;

use Latlog\Models\Target;
use React\ChildProcess\Process;

class PingRunEvent extends Event
{
    public $process;

    public $target;

    /**
     *
     * PingRunEvent constructor.
     * @param Process $process
     * @param Target $target
     */
    public function __construct( Process $process, Target $target )
    {
        $this->process = $process;
        $this->target = $target;
    }
}
