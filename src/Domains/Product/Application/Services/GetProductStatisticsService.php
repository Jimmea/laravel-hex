<?php
namespace App\Domains\Product\Application\Services;

use App\Domains\Product\Domain\Services\ProductStatisticsService;
/**
 * Created by PhpStorm.
 * User: hungokata
 * Date: 2025/11/07 - 09:29
 */
class GetProductStatisticsService
{
    private $statsService;

    public function __construct(ProductStatisticsService $statsService) {
        $this->statsService = $statsService;
    }

    public function execute() {
        return $this->statsService->getCountByCategory();
    }
}