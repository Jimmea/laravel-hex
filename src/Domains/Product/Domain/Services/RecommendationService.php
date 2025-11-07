<?php

namespace App\Domains\Product\Domain\Services;

use App\Domains\Product\Domain\Repositories\ReviewRepositoryInterface; // Thêm interface cho viewRepo
use App\Domains\Product\Domain\Repositories\ProductRepositoryInterface;

class RecommendationService
{
    private $productRepo;
    private $viewRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        ReviewRepositoryInterface $viewRepo // Sử dụng viewRepo thay vì phụ thuộc trực tiếp
    ) {
        $this->productRepo = $productRepo;
        $this->viewRepo = $viewRepo;
    }

    public function getRecommendationsByViewedProducts($userId, $limit = 5): array
    {
        // Lấy danh sách product_id từ product_views
        $viewedProductIds = $this->viewRepo->getViewedProductIdsByUser($userId);
        $categories = [];

        // Lấy danh mục từ các sản phẩm đã xem
        foreach ($viewedProductIds as $productId) {
            $product = $this->productRepo->findById($productId);
            if ($product) {
                $categories[] = $product->getCategory();
            }
        }

        $categories = array_unique($categories);
        $recommended = [];
        foreach ($categories as $category) {
            $products = $this->productRepo->getProductsByCategory($category);
            $recommended = array_merge($recommended, $products);
        }

        // Loại bỏ sản phẩm đã xem và giới hạn số lượng
        $recommended = array_filter($recommended, function ($product) use ($viewedProductIds) {
            return !in_array($product->getId(), $viewedProductIds);
        });
        return array_slice($recommended, 0, $limit);
    }
}