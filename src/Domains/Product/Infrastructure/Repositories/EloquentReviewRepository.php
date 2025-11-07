<?php

namespace App\Domains\Product\Infrastructure\Repositories;

use App\Domains\Product\Domain\Entities\Review;
use App\Domains\Product\Domain\Repositories\ReviewRepositoryInterface;
use App\Domains\Product\Infrastructure\Models\Review as EloquentReview;
use App\Domains\Product\Infrastructure\Models\ProductView as EloquentProductView;

class EloquentReviewRepository implements ReviewRepositoryInterface
{
    public function save(Review $review): void
    {
        $model = new EloquentReview();
        $model->user_id = $review->getUserId();
        $model->product_id = $review->getProductId();
        $model->rating = $review->getRating();
        $model->comment = $review->getComment();
        $model->save();
        $review->setId($model->id);
    }

    public function getReviewsByProductId(int $productId): array
    {
        $models = EloquentReview::where('product_id', $productId)->get();
        $reviews = [];
        foreach ($models as $model) {
            $reviews[] = new Review(
                $model->user_id,
                $model->product_id,
                $model->rating,
                $model->comment
            );
        }
        return $reviews;
    }

    public function getViewedProductIdsByUser($userId)
    {
        return EloquentProductView::where('user_id', $userId)
            ->pluck('product_id')
            ->unique()
            ->values()
            ->all();
    }
}