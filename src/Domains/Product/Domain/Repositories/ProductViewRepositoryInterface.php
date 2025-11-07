<?php

namespace App\Domains\Product\Domain\Repositories;

interface ProductViewRepositoryInterface
{
    public function save($userId, $productId, $timestamp);
    public function getViewedProductIdsByUser($userId);
}