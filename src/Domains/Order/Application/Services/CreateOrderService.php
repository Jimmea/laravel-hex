<?php

namespace App\Domains\Order\Application\Services;

use App\Domains\Order\Domain\Entities\Order;
use App\Domains\Order\Domain\Events\OrderPlacedEvent;
use App\Domains\Order\Domain\Repositories\OrderRepositoryInterface;
use App\Domains\Order\Infrastructure\Jobs\SendOrderConfirmationEmail;
use App\Domains\Product\Domain\Repositories\ProductRepositoryInterface;
use App\Domains\Order\Infrastructure\Mailers\OrderConfirmationMailer;

class CreateOrderService
{
    private $orderRepo;
    private $productRepo;
    private $mailer;

    public function __construct(
        OrderRepositoryInterface $orderRepo,
        ProductRepositoryInterface $productRepo,
        OrderConfirmationMailer $mailer
    ) {
        $this->orderRepo = $orderRepo;
        $this->productRepo = $productRepo;
        $this->mailer = $mailer;
    }

    public function execute($productId, $quantity, $userEmail)
    {
        // Kiểm tra sản phẩm tồn tại
        $product = $this->productRepo->findById($productId); // Ném lỗi nếu không tìm thấy

// Tạo đơn hàng
        $order = new Order($productId, $quantity, $userEmail);
        $this->orderRepo->save($order);

        // Đẩy gửi email vào queue
        SendOrderConfirmationEmail::dispatch($userEmail, $order, $product);

        // Phát sự kiện đơn hàng được đặt
        event(new OrderPlacedEvent($order, $product));

        return $order;
    }
}