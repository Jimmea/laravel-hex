<?php

namespace App\Domains\Product\Application\Services;

use App\Domains\Product\Domain\Services\RecommendationService;

class GetRecommendedProductsService
{
    private $recommendationService;

    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    public function execute($userId, $limit = 5)
    {
        return $this->recommendationService->getRecommendationsByViewedProducts($userId, $limit);
    }
}