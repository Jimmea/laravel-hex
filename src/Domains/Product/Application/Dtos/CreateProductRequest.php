<?php

namespace App\Domains\Product\Application\Dtos;

class CreateProductRequest
{
    public $name;
    public $price;
    public $category;

    public function __construct($name, $price, $category)
    {
        $this->name = $name;
        $this->price = $price;
        $this->category = $category;

        if (empty($name) || $price <= 0) {
            throw new \InvalidArgumentException('Tên không rỗng, giá > 0');
        }
    }
}