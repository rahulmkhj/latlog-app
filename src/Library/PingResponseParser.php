<?php


namespace Latlog\Library;


class PingResponseParser
{
    protected $rawResponse;

    public function __construct( string $rawResponse )
    {
        $this->rawResponse = $rawResponse;
    }
}
