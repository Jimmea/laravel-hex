<?php

namespace App\Domains\Product\Application\Services;

use App\Domains\Product\Domain\Entities\Product;
use App\Domains\Product\Domain\Repositories\ProductRepositoryInterface;

class UpdateProductService
{
    private $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function execute($id, $name, $price, $category, $stock)
    {
        $existingProduct = $this->productRepo->findById($id);
        if (!$existingProduct) {
            throw new \Exception('Sản phẩm không tồn tại.');
        }

        $product = new Product($id, $name, $price, $category, $stock);
        $this->productRepo->update($product);
        return $product;
    }
}