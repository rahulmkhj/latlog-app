<?php


namespace Latlog\Library;

use Exception;


class PingResponse
{
    protected $exitCode;

    protected $rawResponse;

    protected $responseValues = [];


    public function __construct( string $rawResponse )
    {
        $this->rawResponse = $rawResponse;
    }

    public static function parseFromRaw( string $rawResponse ): PingResponse
    {

        $res = new static( $rawResponse );
        $res->extractPD();
        $res->extractLatency();
        return $res;
    }

    public function __get($key)
    {
        if( key_exists($key, $this->responseValues))
        return $this->responseValues[$key];

        throw new Exception("Unknown Parameter: {$key}");
    }

    public function extractPD()
    {
        $pattern = "/[0-9]+%/";
        preg_match( $pattern, $this->rawResponse, $result);
        if( empty($result)) return 1;
        $this->responseValues['lostPercent']   =   rtrim($result[0], '%');
        return $this;
    }

    public function extractLatency()
    {
        $pattern = "/[0-9]+\.[0-9]+\/[0-9]+\.[0-9]+\/[0-9]+\.[0-9]+\/[0-9]+\.[0-9]+/";
        preg_match( $pattern, $this->rawResponse, $result );
        if( empty($result)) return false;
        $keys = ['min', 'avg', 'max', 'stddev'];
        $values = explode('/', $result[0]);
        $this->responseValues = array_merge(
                                    $this->responseValues,
                                    array_combine( $keys, $values )
                                );
        return $this;
    }

}
