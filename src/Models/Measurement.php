<?php


namespace Latlog\Models;


use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    protected $fillable = [
        'host', 'result', 'exitCode', 'min', 'avg', 'max', 'stddev',
        'exitcode', 'lostPercent',
    ];

}
