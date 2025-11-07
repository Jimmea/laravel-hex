<?php

namespace App\Domains\Order\Domain\Events;

use App\Domains\Order\Domain\Entities\Order;
use App\Domains\Product\Domain\Entities\Product;

class OrderPlacedEvent
{
    public $order;
    public $product;

    public function __construct(Order $order, Product $product)
    {
        $this->order = $order;
        $this->product = $product;
    }
}