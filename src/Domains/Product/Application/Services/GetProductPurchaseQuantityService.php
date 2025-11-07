<?php
namespace App\Domains\Product\Application\Services;
use App\Domains\Order\Domain\Repositories\OrderRepositoryInterface;

/**
 * Created by PhpStorm.
 * User: hungokata
 * Date: 2025/11/07 - 09:29
 */
class GetProductPurchaseQuantityService
{
    private $orderRepo;

    public function __construct(OrderRepositoryInterface $orderRepo) {
        $this->orderRepo = $orderRepo;
    }

    public function execute($productId) {
        return $this->orderRepo->getTotalQuantityByProductId($productId);
    }
}