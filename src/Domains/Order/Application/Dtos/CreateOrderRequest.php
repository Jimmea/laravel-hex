<?php

namespace App\Domains\Order\Application\Dtos;

class CreateOrderRequest
{
    public $productId;
    public $quantity;
    public $userEmail;

    public function __construct($productId, $quantity, $userEmail)
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->userEmail = $userEmail;
        if ($productId <= 0 || $quantity <= 0 || empty($userEmail)) {
            throw new \InvalidArgumentException('Product ID, quantity phải lớn hơn 0, email không được rỗng');
        }
    }
}