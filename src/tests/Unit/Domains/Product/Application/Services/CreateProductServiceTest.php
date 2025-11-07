<?php

namespace Tests\Unit\Domains\Product\Application\Services;

use App\Domains\Product\Application\Dtos\CreateProductRequest;
use App\Domains\Product\Application\Services\CreateProductService;
use App\Domains\Product\Domain\Entities\Product;
use App\Domains\Product\Domain\Repositories\ProductRepositoryInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

class CreateProductServiceTest extends TestCase
{
    protected $productRepo;
    protected $createService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productRepo = Mockery::mock(ProductRepositoryInterface::class);
        $this->createService = new CreateProductService($this->productRepo);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testCreateProductSuccessfully()
    {
        $dto = new CreateProductRequest('Sách', 10.99, 'Sách', 100);
        $product = new Product(1, $dto->name, $dto->price, $dto->category, $dto->stock);

        $this->productRepo->shouldReceive('save')->once()->with(Mockery::on(function ($arg) use ($product) {
            return $arg->getName() === $product->getName() &&
                $arg->getPrice() === $product->getPrice() &&
                $arg->getCategory() === $product->getCategory() &&
                $arg->getStock() === $product->getStock();
        }));

        $result = $this->createService->execute($dto);
        $this->assertInstanceOf(Product::class, $result);
    }

    public function testCreateProductWithInvalidPrice()
    {
        $this->expectException(\InvalidArgumentException::class);
        $dto = new CreateProductRequest('Sách', -1, 'Sách', 100);
        $this->createService->execute($dto);
    }

    public function testCreateProductWithEmptyName()
    {
        $this->expectException(\InvalidArgumentException::class);
        $dto = new CreateProductRequest('', 10.99, 'Sách', 100);
        $this->createService->execute($dto);
    }

    public function testCreateProductWithInvalidCategory()
    {
        $this->expectException(\InvalidArgumentException::class);
        $dto = new CreateProductRequest('Sách', 10.99, 'Không hợp lệ', 100);
        $this->createService->execute($dto);
    }

    public function testCreateProductWithNegativeStock()
    {
        $this->expectException(\InvalidArgumentException::class);
        $dto = new CreateProductRequest('Sách', 10.99, 'Sách', -1);
        $this->createService->execute($dto);
    }
}