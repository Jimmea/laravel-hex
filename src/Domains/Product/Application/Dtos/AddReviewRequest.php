<?php

namespace App\Domains\Product\Application\Dtos;

class AddReviewRequest
{
    public $userId;
    public $productId;
    public $rating;
    public $comment;

    public function __construct($userId, $productId, $rating, $comment)
    {
        $this->userId = $userId;
        $this->productId = $productId;
        $this->rating = $rating;
        $this->comment = $comment;
        if ($userId <= 0 || $productId <= 0 || $rating < 1 || $rating > 5 || strlen($comment) > 500) {
            throw new \InvalidArgumentException('Dữ liệu đánh giá không hợp lệ.');
        }
    }
}