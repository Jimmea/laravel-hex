<?php

namespace App\Domains\Order\Domain\Repositories;
use App\Domains\Order\Infrastructure\Models\Order as EloquentOrder;


interface OrderRepositoryInterface
{
    public function save(EloquentOrder $order): void;
    public function getTotalQuantityByProductId($productId): int;
}