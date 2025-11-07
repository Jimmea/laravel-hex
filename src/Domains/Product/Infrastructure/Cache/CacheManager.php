<?php

namespace App\Domains\Product\Infrastructure\Cache;

use Illuminate\Support\Facades\Cache;

class CacheManager
{
    private $key = 'product_views';
    private $driver;

    public function __construct($driver = null)
    {
        $this->driver = $driver ?: config('cache.default', 'redis');
    }

    public function log($data)
    {
        $logData = json_encode($data);
        return Cache::store($this->driver)->lpush($this->key, $logData);
    }

    public function getLogs()
    {
        return Cache::store($this->driver)->lrange($this->key, 0, -1);
    }

    public function clear()
    {
        return Cache::store($this->driver)->del($this->key);
    }

}