<?php

namespace App\Domains\Order\Infrastructure\Jobs;

use App\Domains\Order\Domain\Entities\Order;
use App\Domains\Product\Domain\Entities\Product;
use App\Domains\Order\Infrastructure\Mailers\OrderConfirmationMailer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOrderConfirmationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userEmail;
    public $order;
    public $product;

    public function __construct($userEmail, Order $order, Product $product)
    {
        $this->userEmail = $userEmail;
        $this->order = $order;
        $this->product = $product;
    }

    public function handle(OrderConfirmationMailer $mailer)
    {
        $mailer->send($this->userEmail, $this->order, $this->product);
    }
}