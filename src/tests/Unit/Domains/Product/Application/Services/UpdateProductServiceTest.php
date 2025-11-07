<?php

namespace Tests\Unit\Domains\Product\Application\Services;

use App\Domains\Product\Application\Services\UpdateProductService;
use App\Domains\Product\Domain\Entities\Product;
use App\Domains\Product\Domain\Repositories\ProductRepositoryInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

class UpdateProductServiceTest extends TestCase
{
    protected $productRepo;
    protected $updateService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productRepo = Mockery::mock(ProductRepositoryInterface::class);
        $this->updateService = new UpdateProductService($this->productRepo);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testUpdateProductSuccessfully()
    {
        $product = new Product(1, 'Sách Cập Nhật', 15.99, 'Sách', 50);

        $this->productRepo->shouldReceive('findById')->with(1)->andReturn($product);
        $this->productRepo->shouldReceive('update')->once()->with(Mockery::on(function ($arg) use ($product) {
            return $arg->getId() === $product->getId() &&
                $arg->getName() === $product->getName() &&
                $arg->getPrice() === $product->getPrice() &&
                $arg->getCategory() === $product->getCategory() &&
                $arg->getStock() === $product->getStock();
        }));

        $result = $this->updateService->execute(1, 'Sách Cập Nhật', 15.99, 'Sách', 50);
        $this->assertInstanceOf(Product::class, $result);
    }

    public function testUpdateProductWithInvalidPrice()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->updateService->execute(1, 'Sách', -1, 'Sách', 50);
    }

    public function testUpdateProductWithInvalidCategory()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->updateService->execute(1, 'Sách', 10.99, 'Không hợp lệ', 50);
    }

    public function testUpdateNonExistentProduct()
    {
        $this->productRepo->shouldReceive('findById')->with(1)->andReturn(null);
        $this->expectException(\Exception::class); // Giả định ném ngoại lệ nếu không tìm thấy
        $this->updateService->execute(1, 'Sách', 10.99, 'Sách', 50);
    }
}