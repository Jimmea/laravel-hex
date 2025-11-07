<?php

namespace App\Domains\Product\Application\Services;

use App\Domains\Product\Domain\Entities\Review;
use App\Domains\Product\Domain\Repositories\ReviewRepositoryInterface;

class AddReviewService
{
    private $reviewRepo;

    public function __construct(ReviewRepositoryInterface $reviewRepo)
    {
        $this->reviewRepo = $reviewRepo;
    }

    public function execute($userId, $productId, $rating, $comment)
    {
        $review = new Review($userId, $productId, $rating, $comment);
        $this->reviewRepo->save($review);
        return $review;
    }
}