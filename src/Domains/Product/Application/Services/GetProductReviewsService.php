<?php

namespace App\Domains\Product\Application\Services;

use App\Domains\Product\Domain\Repositories\ReviewRepositoryInterface;

class GetProductReviewsService
{
    private $reviewRepo;

    public function __construct(ReviewRepositoryInterface $reviewRepo)
    {
        $this->reviewRepo = $reviewRepo;
    }

    public function execute($productId)
    {
        return $this->reviewRepo->getReviewsByProductId($productId);
    }
}