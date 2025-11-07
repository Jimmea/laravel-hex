<?php

namespace App\Domains\Order\Infrastructure\Listeners;

use App\Domains\Order\Domain\Events\OrderPlacedEvent;
use Illuminate\Support\Facades\Log;

class LogOrderPlaced
{
    public function handle(OrderPlacedEvent $event)
    {
        Log::info('Đơn hàng đã được đặt', [
            'order_id' => $event->order->getId(),
            'product_id' => $event->order->getProductId(),
            'quantity' => $event->order->getQuantity(),
        ]);
    }
}