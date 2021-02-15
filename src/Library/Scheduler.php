<?php


namespace Latlog\Library;


use Latlog\Models\Target;

class Scheduler
{
    protected static $running = [];

    public static function all(): array
    {
        return static::$running;
    }

    public static function start( Target $target )
    {
        static::$running[ $target->id ] = ( new Ping() )
                                            ->setTarget($target)
                                            ->run();
    }

    public static function stop( int $targetId ): void
    {
        app('loop')->cancelTimer(
                    static::$running[ $targetId ]
        );
        unset( static::$running[ $targetId ] );
    }

    public static function isRunning( int $targetId ): bool
    {
        return isset(
            static::$running[ $targetId ]
        );
    }

}
