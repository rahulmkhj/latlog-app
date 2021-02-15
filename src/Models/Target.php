<?php


namespace Latlog\Models;


use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $fillable = [
        'host', 'count', 'interval', 'size', 'ttl', 'timeout', 'frequency',
    ];

    public function measurements(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Measurement::class);
    }

    public function isNew(): bool
    {
        return static::where('id', $this->id)->exists();
    }

    public function haveBeenRemoved(): bool
    {
        return ! $this->isNew();
    }

    public function buildCommand(): string
    {
        return "ping {$this->host}"
            . $this->size()
            . $this->count()
            . $this->ttl()
            . $this->interval()
            . $this->timeout()
            . $this->quite()
            ;
    }

    protected function size(): string
    {
        return " -s {$this->size}";
    }

    protected function count(): string
    {
        return " -c {$this->count}";
    }

    protected function ttl(): string
    {
        return " -t {$this->ttl}";
    }

    protected function interval(): string
    {
        return " -i {$this->interval}";
    }

    protected function timeout(): string
    {
        return " -W {$this->timeout}";
    }

    protected function quite(): string
    {
        return " -q";
    }
}
