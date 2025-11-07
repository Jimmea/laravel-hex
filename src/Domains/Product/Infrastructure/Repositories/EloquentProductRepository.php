<?php

namespace App\Domains\Product\Infrastructure\Repositories;

use App\Domains\Product\Domain\Entities\Product;
use App\Domains\Product\Domain\Repositories\ProductRepositoryInterface;
use App\Domains\Product\Infrastructure\Models\Product as EloquentProduct;
use App\Domains\Product\Infrastructure\Models\ProductView;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function save(Product $product): void
    {
        $model = new EloquentProduct();
        $model->name = $product->getName();
        $model->price = $product->getPrice();
        $model->category = $product->getCategory();
        $model->save();
        $product->setId($model->id); // Set ID sau khi lưu
    }

    public function findById($id): Product
    {
        $model = EloquentProduct::findOrFail($id);
        return new Product($model->name, $model->price, $model->category);
    }

    public function search($query): array
    {
        $models = EloquentProduct::where('name', 'like', "%$query%")->get();

        $products = [];
        foreach ($models as $model) {
            $products[] = new Product($model->name, $model->price, $model->category);
        }
        return $products;
    }

    public function countByCategory(): array
    {
        return EloquentProduct::groupBy('category')->selectRaw('category, count(*) as count')->pluck('count', 'category')->toArray();
    }

    public function getDailyViews(int $userId): int
    {
        return ProductView::where('user_id', $userId)
            ->whereDate('viewed_at', today())
            ->count();
    }

    public function getProductsByCategory(string $category): array
    {
        $products = EloquentProduct::where('category', $category)->get();
        return array_map(function ($product) {
            return new Product(
                $product->id,
                $product->name,
                $product->price,
                $product->category,
                $product->stock
            );
        }, $products->all());
    }

    public function getPopularProducts(int $limit = 5): array
    {
        // Giả định lấy sản phẩm phổ biến dựa trên số lượt xem
        $productIds = ProductView::select('product_id', \DB::raw('count(*) as view_count'))
            ->groupBy('product_id')
            ->orderByDesc('view_count')
            ->limit($limit)
            ->pluck('product_id')
            ->all();

        $products = [];
        foreach ($productIds as $id) {
            $product = $this->findById($id);
            if ($product) {
                $products[] = $product;
            }
        }
        return $products;
    }
}