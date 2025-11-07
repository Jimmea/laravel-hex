<?php

// src/Domains/Product/Domain/Services/ProductStatisticsService.php (Domain)
namespace App\Domains\Product\Domain\Services;

use App\Domains\Product\Domain\Repositories\ProductRepositoryInterface;

class ProductStatisticsService {
    private $repo;

    public function __construct(ProductRepositoryInterface $repo) {
        $this->repo = $repo;
    }

    public function getCountByCategory() {
        // Logic aggregate ở đây, nhưng delegate sang repo để query
        return $this->repo->countByCategory();
    }
}