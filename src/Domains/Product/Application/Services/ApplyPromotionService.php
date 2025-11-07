<?php
/**
 * Created by PhpStorm.
 * User: hungokata
 * Date: 2025/11/07 - 14:08
 */

namespace App\Domains\Product\Application\Services;

use App\Domains\Product\Domain\Repositories\ProductRepositoryInterface;
use App\Domains\Product\Domain\Services\PromotionService;

class ApplyPromotionService
{
    protected $promotionService;
    protected $repo;

    public function __construct(
        ProductRepositoryInterface $repo,
        PromotionService           $promotionService)
    {
        $this->repo             = $repo;
        $this->promotionService = $promotionService;
    }

    public function execute($productId, $discount, $startDate, $endDate)
    {
        $product = $this->repo->findById($productId);
        $this->promotionService->validatePromotion($product, $discount, $startDate, $endDate);
        $this->repo->save($product);
    }
}