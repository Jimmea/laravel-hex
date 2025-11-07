<?php

namespace App\Domains\Product\Domain\Repositories;

use App\Domains\Product\Domain\Entities\Review;

interface ReviewRepositoryInterface
{
    public function save(Review $review): void;

    public function getReviewsByProductId(int $productId);

    public function getViewedProductIdsByUser($userId);
}