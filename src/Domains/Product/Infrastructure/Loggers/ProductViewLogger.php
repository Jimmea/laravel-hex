<?php

namespace App\Domains\Product\Infrastructure\Loggers;

use Illuminate\Support\Facades\Auth;
use App\Domains\Product\Infrastructure\Cache\CacheManager;

class ProductViewLogger
{
    private $cacheManager;

    public function __construct(CacheManager $cacheManager)
    {
        $this->cacheManager = $cacheManager;
    }

    public function logView($productId)
    {
        $userId = Auth::id() ?? 'guest'; // Giả định auth
        $timestamp = now()->timestamp;
        $logData = ['user_id' => $userId, 'product_id' => $productId, 'timestamp' => $timestamp];

        $this->cacheManager->log($logData);
    }
}