<?php

namespace App\Domains\Product\Infrastructure\Repositories;

use App\Domains\Product\Domain\Repositories\ProductViewRepositoryInterface;
use App\Domains\Product\Infrastructure\Models\ProductView as EloquentProductView;
use App\Domains\Product\Domain\Services\ProductViewService;

class EloquentProductViewRepository implements ProductViewRepositoryInterface
{
    private $viewService;

    public function __construct(ProductViewService $viewService)
    {
        $this->viewService = $viewService;
    }

    public function save($userId, $productId, $timestamp)
    {
        $this->viewService->checkViewLimit($userId);

        $model = new EloquentProductView();
        $model->user_id = $userId;
        $model->product_id = $productId;
        $model->viewed_at = date('Y-m-d H:i:s', $timestamp);
        $model->save();
    }

    public function getViewedProductIdsByUser($userId)
    {
        return EloquentProductView::where('user_id', $userId)
            ->pluck('product_id')
            ->unique()
            ->values()
            ->all();
    }
}