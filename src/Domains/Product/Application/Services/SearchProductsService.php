<?php

// src/Domains/Product/Application/Services/SearchProductsService.php
namespace App\Domains\Product\Application\Services;

use App\Domains\Product\Domain\Repositories\ProductRepositoryInterface;

class SearchProductsService
{
    private $repo;

    public function __construct(ProductRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function execute($query)
    {
        return $this->repo->search($query);
    }
}