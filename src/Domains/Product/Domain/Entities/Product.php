<?php

namespace App\Domains\Product\Domain\Entities;

class Product
{
    private $id;
    private $name;
    private $price;
    private $category;
    private $stock;

    public function __construct($id, $name, $price, $category, $stock = 0)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setPrice($price);
        $this->setCategory($category);
        $this->setStock($stock);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        if (empty(trim($name))) {
            throw new \InvalidArgumentException('Tên sản phẩm không được để trống.');
        }
        if (strlen($name) > 100) {
            throw new \InvalidArgumentException('Tên sản phẩm không được vượt quá 100 ký tự.');
        }
        $this->name = $name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        if ($price <= 0) {
            throw new \InvalidArgumentException('Giá phải lớn hơn 0.');
        }
        if ($price > 1000000) {
            throw new \InvalidArgumentException('Giá không được vượt quá 1,000,000.');
        }
        $this->price = $price;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): void
    {
        $allowedCategories = ['Sách', 'Đồ điện tử', 'Thời trang', 'Ẩm thực'];
        if (empty(trim($category))) {
            throw new \InvalidArgumentException('Danh mục không được để trống.');
        }
        if (!in_array($category, $allowedCategories)) {
            throw new \InvalidArgumentException('Danh mục không hợp lệ.');
        }
        $this->category = $category;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): void
    {
        if ($stock < 0) {
            throw new \InvalidArgumentException('Số lượng tồn kho không được âm.');
        }
        $this->stock = $stock;
    }

    public function isAvailable(): bool
    {
        return $this->stock > 0;
    }

    public function applyDiscount(float $discountPercentage): void
    {
        if ($discountPercentage < 0 || $discountPercentage > 50) {
            throw new \InvalidArgumentException('Phần trăm giảm giá phải từ 0 đến 50%.');
        }
        $this->price = $this->price * (1 - $discountPercentage / 100);
    }

    public function applyPromotion(array $promotion): void
    {
        $now = time();
        if ($now < strtotime($promotion['start_date']) || $now > strtotime($promotion['end_date'])) {
            throw new \Exception('Khuyến mãi không áp dụng.');
        }
        $this->applyDiscount($promotion['discount_percentage']);
    }
}