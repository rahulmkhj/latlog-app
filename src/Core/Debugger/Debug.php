<?php


namespace Latlog\Core\Debugger;

use Illuminate\Console\OutputStyle;


class Debug
{
    /**
     * @var OutputStyle
     */
    protected static $logger;

    /**
     * @var bool
     */
    protected static $debugMode = false;

    /**
     * enable debug mode.
     */
    public static function enable(): void
    {
        static::$debugMode = true;
    }

    /**
     * @return OutputStyle
     */
    public static function getLogger(): OutputStyle
    {
        if( static::$logger == null )
            static::$logger = app('console.output');
        return static::$logger;
    }

    /**
     * @param $name
     * @param $arguments
     */
    public static function __callStatic($name, $arguments)
    {
        if( static::$debugMode
            && method_exists(static::getLogger(), $name)
        ) static::getLogger()->$name(...$arguments);
    }

}
