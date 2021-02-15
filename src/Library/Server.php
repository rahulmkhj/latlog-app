<?php


namespace Latlog\Library;


use Latlog\Events\TargetUpdateEvent;
use Latlog\Models\Target;
use React\Socket\ConnectionInterface;
use React\Socket\UnixServer;

class Server
{
    /**
     *Star the server process.
     */
    public static function start(): void
    {
        $server = new static();

        $server->queueExistingTargets()
                ->listenForUpdates();
    }

    /**
     * On start, fetches all existing targets on the database
     * and start the scheduler for each of them.
     *
     * @return $this
     */
    public function queueExistingTargets(): Server
    {
        $targets = Target::all();

        foreach( $targets as $target )
        {
            Scheduler::start( $target );
        }
        return $this;
    }

    /**
     * Creates a unix server to listen for target
     * create/remove updates using CLI utility
     */
    public function listenForUpdates(): void
    {
        $socketPath = config('latlog.socket_path');

        $this->_clearOldSocket( $socketPath );

        $server = new UnixServer(
                                $socketPath,
                                app('loop')
                            );
//        echo "Listening On: unix://" . $socketPath . "\n";

        $server->on('connection', function( ConnectionInterface $c ){
            $c->on('data', function ( $targetId ){
                event( new TargetUpdateEvent( intval($targetId) ) );
            });
        });
    }

    /**
     * creating a Unix Server will try to create a new .sock file
     * so we check & delete it if it exists from the
     * previous session.
     *
     * @param string $socketPath
     */
    protected function _clearOldSocket( string $socketPath )
    {
        if( file_exists($socketPath) ):
            unlink($socketPath);
        endif;
    }

}
