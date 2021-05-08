<?php


namespace Latlog\Commands;


use Latlog\Core\Debugger\Debug;
use Latlog\Library\Server;
use \Illuminate\Console\Command;


class PingListenerCommand extends Command
{

    /**
     * Command signature, used to invoke the command.
     *
     * @var string
     */
    protected $signature = "ping:listen";

    /**
     * Start the ping measurement server.
     */
    public function handle(): void
    {
        if( $this->option('verbose') )
            Debug::enable();

        Server::start();

        app('loop')->run();
    }

}
