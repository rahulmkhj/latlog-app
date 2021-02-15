<?php


namespace Latlog\Commands;


use Latlog\Library\Server;
use \Illuminate\Console\Command;


class PingListenerCommand extends Command
{

    /**
     * @var string
     */
    protected $signature = "ping:listen";

    /**
     * Start the ping measurement server.
     */
    public function handle(): void
    {
        Server::start();

        app('loop')->run();
    }

}
