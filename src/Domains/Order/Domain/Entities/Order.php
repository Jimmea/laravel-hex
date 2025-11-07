<?php

namespace App\Domains\Order\Domain\Entities;

class Order
{
    private $id;
    private $productId;
    private $quantity;
    private $userEmail;

    public function __construct($productId, $quantity, $userEmail)
    {
        $this->validate($productId, $quantity, $userEmail);
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->userEmail = $userEmail;
    }

    private function validate($productId, $quantity, $userEmail)
    {
        if ($productId <= 0 || $quantity <= 0 || empty($userEmail)) {
            throw new \InvalidArgumentException('Product ID, quantity phải lớn hơn 0, email không được rỗng');
        }
    }

    public function getId() { return $this->id; }
    public function getProductId() { return $this->productId; }
    public function getQuantity() { return $this->quantity; }
    public function getUserEmail() { return $this->userEmail; }
    public function setId($id) { $this->id = $id; }
}