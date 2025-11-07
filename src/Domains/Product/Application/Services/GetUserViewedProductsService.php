<?php

namespace App\Domains\Product\Application\Services;

use App\Domains\Product\Domain\Repositories\ProductRepositoryInterface;
use App\Domains\Product\Infrastructure\Repositories\EloquentProductViewRepository;

class GetUserViewedProductsService
{
    private $productRepo;
    private $viewRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        EloquentProductViewRepository $viewRepo
    ) {
        $this->productRepo = $productRepo;
        $this->viewRepo = $viewRepo;
    }

    public function execute($userId)
    {
        // Lấy danh sách product_id từ product_views
        $viewedProductIds = $this->viewRepo->getViewedProductIdsByUser($userId);

        // Lấy thông tin chi tiết sản phẩm
        $products = [];
        foreach ($viewedProductIds as $productId) {
            $product = $this->productRepo->findById($productId);
            if ($product) {
                $products[] = [
                    'id' => $product->getId(),
                    'name' => $product->getName(),
                    'price' => $product->getPrice(),
                    'category' => $product->getCategory(),
                ];
            }
        }

        return $products;
    }
}