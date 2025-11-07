<?php

namespace App\Domains\Order\Infrastructure\Mailers;

use App\Domains\Order\Domain\Entities\Order;
use App\Domains\Product\Domain\Entities\Product;
use Illuminate\Support\Facades\Mail;

class OrderConfirmationMailer
{
    public function send($userEmail, Order $order, Product $product)
    {
        Mail::to($userEmail)->send(new class($order, $product) extends \Illuminate\Mail\Mailable {
            private $order;
            private $product;

            public function __construct(Order $order, Product $product)
            {
                $this->order = $order;
                $this->product = $product;
            }

            public function build()
            {
                return $this->subject('Xác Nhận Đơn Hàng')
                    ->view('emails.order_confirmation')
                    ->with([
                        'product_name' => $this->product->getName(),
                        'quantity' => $this->order->getQuantity(),
                        'total_price' => $this->product->getPrice() * $this->order->getQuantity(),
                    ]);
            }
        });
    }
}