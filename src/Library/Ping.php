<?php


namespace Latlog\Library;


use Latlog\Core\Debugger\Debug;
use Latlog\Events\PingRunEvent;
use Latlog\Models\Target;
use React\ChildProcess\Process;
use React\EventLoop\TimerInterface;

class Ping
{
    protected $target;

    public function setTarget( Target $target ): Ping
    {
        $this->target = $target;
        return $this;
    }

    public function run(): TimerInterface
    {
        $this->runOnce();
        return $this->schedule();
    }

    public function runOnce(): Ping
    {
        $time = date('h:i:s');
        Debug::info("running: {$this->target->buildCommand()} at {$time} for Target ID: {$this->target->id}");

        $process = new Process("exec {$this->target->buildCommand()}");
        $process->start(app('loop'));
        event(new PingRunEvent($process, $this->target));
        return $this;
    }

    public function schedule(): TimerInterface
    {
        Debug::info("Scheduling {$this->target->host} to be probed every {$this->target->frequency} seconds");

        $that = $this;
        return app('loop')->addPeriodicTimer( $this->target->frequency, function() use ($that){
                    $that->runOnce();
                });
    }


}
