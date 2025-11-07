<?php

namespace App\Domains\Product\Infrastructure\Transformers;

use App\Domains\Product\Domain\Entities\Product;

class ProductTransformer
{
    public static function transform(Product $product): array
    {
        return [
            'id' => $product->getId(),
            'product_name' => $product->getName(),
            'formatted_price' => number_format($product->getPrice(), 2) . ' VND',
            'category' => $product->getCategory(),
            'is_available' => $product->isAvailable(),
            'stock' => $product->getStock(),
        ];
    }

    public static function transformCollection(array $products): array
    {
        return array_map([self::class, 'transform'], $products);
    }
}