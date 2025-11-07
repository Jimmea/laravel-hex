<?php
/**
 * Created by PhpStorm.
 * User: hungokata
 * Date: 2025/11/07 - 14:09
 */

namespace App\Domains\Product\Infrastructure\Repositories;

use App\Domains\Product\Infrastructure\Models\Promotion;

class EloquentPromotionRepository
{
    public function getActivePromotions()
    {
        return Promotion::where('end_date', '>', now())->get();
    }
}