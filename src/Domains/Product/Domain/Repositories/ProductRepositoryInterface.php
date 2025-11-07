<?php
/**
 * Created by PhpStorm.
 * User: hungokata
 * Date: 2025/11/07 - 09:30
 */

// src/Domains/Product/Domain/Repositories/ProductRepositoryInterface.php (Domain Layer)
namespace App\Domains\Product\Domain\Repositories;

use App\Domains\Product\Domain\Entities\Product;

interface ProductRepositoryInterface
{
    public function save(Product $product): void;
    // Các method khác: findById, search, etc.

    // Thêm vào ProductRepositoryInterface.php
    public function findById($id): Product;

    // Thêm vào ProductRepositoryInterface.php
    public function search($query): array; // Trả mảng Product

    public function countByCategory(): array; // Ví dụ: ['category1' => 10, 'category2' => 5]

    public function getDailyViews(int $userId): int; // Thêm phương thức lấy số lượt xem trong ngày

    public function getProductsByCategory(string $category): array; // Thêm phương thức lấy sản phẩm theo danh mục

    public function getPopularProducts(int $limit = 5): array;

    public function update(Product $product): void; // Thêm phương thức cập nhật
}