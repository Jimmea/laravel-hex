<?php

namespace App\Providers;

use App\Domains\Product\Domain\Services\RecommendationService;
use App\Domains\Product\Infrastructure\Repositories\EloquentProductRepository;
use App\Domains\Product\Domain\Repositories\ProductRepositoryInterface;
use App\Domains\Order\Infrastructure\Repositories\EloquentOrderRepository;
use App\Domains\Order\Domain\Repositories\OrderRepositoryInterface;
use App\Domains\Product\Infrastructure\Cache\CacheManager;
use App\Domains\Product\Domain\Services\ProductViewService;
use App\Domains\Product\Domain\Repositories\ProductViewRepositoryInterface;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            ProductRepositoryInterface::class,
            EloquentProductRepository::class
        );
        $this->app->bind(
            OrderRepositoryInterface::class,
            EloquentOrderRepository::class
        );
        $this->app->bind(CacheManager::class, function ($app) {
            return new CacheManager();
        });
        $this->app->bind(ProductViewService::class, function ($app) {
            return new ProductViewService($app->make(ProductRepositoryInterface::class));
        });

        $this->app->bind(RecommendationService::class, function ($app) {

            return new RecommendationService(
                $app->make(ProductRepositoryInterface::class),
                $app->make(ProductViewRepositoryInterface::class)
            );

        });
    }

    public function boot()
    {
        //
    }
}