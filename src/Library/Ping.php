<?php


namespace Latlog\Library;


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
        echo "running: {$this->target->buildCommand()} - {$time} with ID: {$this->target->id} \n";
        $process = new Process("exec {$this->target->buildCommand()}");
        $process->start(app('loop'));
        event(new PingRunEvent($process, $this->target));
        return $this;
    }

    public function schedule(): TimerInterface
    {
        $that = $this;
        return app('loop')->addPeriodicTimer( $this->target->frequency, function() use ($that){
                    $that->runOnce();
                });
//        Scheduler::attach( $this->target, $timer );
    }


}
