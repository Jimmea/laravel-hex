<?php
/**
 * Created by PhpStorm.
 * User: hungokata
 * Date: 2025/11/07 - 14:08
 */

namespace App\Domains\Product\Domain\Services;

use App\Domains\Product\Domain\Entities\Product;

class PromotionService
{
    public function validatePromotion(Product $product, $discount, $startDate, $endDate)
    {
        if ($discount > 50) throw new \Exception('Giảm giá tối đa 50%.');
        $product->applyPromotion(['discount_percentage' => $discount, 'start_date' => $startDate, 'end_date' => $endDate]);
    }
}