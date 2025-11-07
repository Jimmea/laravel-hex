<?php

namespace App\Domains\Product\Application\Services;

use App\Domains\Product\Domain\Repositories\ProductRepositoryInterface;
use App\Domains\Product\Infrastructure\Loggers\ProductViewLogger;
use App\Domains\Product\Domain\Services\ProductViewService;

class GetProductDetailService
{
    private $repo;
    private $logger;
    private $viewService;

    public function __construct(
        ProductRepositoryInterface $repo,
        ProductViewLogger $logger,
        ProductViewService $viewService
    ) {
        $this->repo = $repo;
        $this->logger = $logger;
        $this->viewService = $viewService;
    }

    public function execute($id)
    {
        $userId = auth()->id() ?? 'guest'; // Giả định auth
        $this->viewService->checkViewLimit($userId); // Kiểm tra giới hạn

        $product = $this->repo->findById($id);

        // Log view vào cache
        $this->logger->logView($id);

        return $product;
    }
}