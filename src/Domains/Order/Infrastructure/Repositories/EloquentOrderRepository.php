<?php

namespace App\Domains\Order\Infrastructure\Repositories;

use App\Domains\Order\Domain\Repositories\OrderRepositoryInterface;
use App\Domains\Order\Infrastructure\Models\Order as EloquentOrder;

class EloquentOrderRepository implements OrderRepositoryInterface
{
    public function save(Order $order): void
    {
        $model = new EloquentOrder();
        $model->product_id = $order->getProductId();
        $model->quantity = $order->getQuantity();
        $model->user_email = $order->getUserEmail();
        $model->save();
        $order->setId($model->id);
    }

    public function getTotalQuantityByProductId($productId): int
    {
        return EloquentOrder::where('product_id', $productId)->sum('quantity');
    }
}