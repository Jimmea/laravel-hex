<?php

namespace App\Domains\Product\Domain\Services;

use App\Domains\Product\Domain\Repositories\ProductRepositoryInterface;

class ProductViewService
{
    private $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function checkViewLimit($userId, $maxViews = 10)
    {
        $dailyViews = $this->productRepo->getDailyViews($userId);
        if ($dailyViews >= $maxViews) {
            throw new \Exception('Đã đạt giới hạn số lượt xem trong ngày: ' . $maxViews);
        }
        return true;
    }

    public function getPopularProducts($limit = 5)
    {
        // Logic giả định lấy sản phẩm phổ biến dựa trên số lượt xem
        // Cần triển khai trong repository
        return $this->productRepo->getPopularProducts($limit);
    }
}