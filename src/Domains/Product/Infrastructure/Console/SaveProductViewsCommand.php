<?php

namespace App\Domains\Product\Infrastructure\Commands;

use Illuminate\Console\Command;
use App\Domains\Product\Infrastructure\Repositories\EloquentProductViewRepository;
use App\Domains\Product\Infrastructure\Cache\CacheManager;

class SaveProductViewsCommand extends Command
{
    protected $signature = 'log:save-product-views';

    protected $description = 'Đọc log view sản phẩm từ Redis và save vào database';

    private $viewRepo;
    private $cacheManager;

    public function __construct(EloquentProductViewRepository $viewRepo, CacheManager $cacheManager)
    {
        parent::__construct();
        $this->viewRepo = $viewRepo;
        $this->cacheManager = $cacheManager;
    }

    public function handle()
    {
        $logs = $this->cacheManager->getLogs();

        foreach ($logs as $log) {
            $data = json_decode($log, true);
            $this->viewRepo->save($data['user_id'], $data['product_id'], $data['timestamp']);
        }

        // Xóa log từ cache sau khi save
        $this->cacheManager->clear();

        $this->info('Đã save ' . count($logs) . ' log view vào database.');
    }
}