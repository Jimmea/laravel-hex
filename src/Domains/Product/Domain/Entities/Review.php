<?php

namespace App\Domains\Product\Domain\Entities;

class Review
{
    private $id;
    private $userId;
    private $productId;
    private $rating;
    private $comment;

    public function __construct($userId, $productId, $rating, $comment)
    {
        $this->setUserId($userId);
        $this->setProductId($productId);
        $this->setRating($rating);
        $this->setComment($comment);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        if ($userId <= 0) {
            throw new \InvalidArgumentException('User ID phải lớn hơn 0.');
        }
        $this->userId = $userId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function setProductId(int $productId): void
    {
        if ($productId <= 0) {
            throw new \InvalidArgumentException('Product ID phải lớn hơn 0.');
        }
        $this->productId = $productId;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating): void
    {
        if ($rating < 1 || $rating > 5) {
            throw new \InvalidArgumentException('Rating phải từ 1 đến 5.');
        }
        $this->rating = $rating;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): void
    {
        if (strlen($comment) > 500) {
            throw new \InvalidArgumentException('Comment không được vượt quá 500 ký tự.');
        }
        $this->comment = $comment;
    }
}