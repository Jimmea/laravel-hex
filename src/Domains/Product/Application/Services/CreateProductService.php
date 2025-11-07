<?php

// src/Domains/Product/Application/Services/CreateProductService.php (Application Layer)
namespace App\Domains\Product\Application\Services;

use App\Domains\Product\Domain\Entities\Product;
use App\Domains\Product\Domain\Repositories\ProductRepositoryInterface;

class CreateProductService {
    private $repo;

    public function __construct(ProductRepositoryInterface $repo) {
        $this->repo = $repo;
    }

    public function execute($name, $price, $category) {
        $product = new Product($name, $price, $category);
        $this->repo->save($product);
        return $product;
    }
}