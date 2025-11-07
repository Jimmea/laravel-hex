<?php

namespace App\Domains\Order\Infrastructure\Http\Controllers;

use App\Domains\Order\Application\Dtos\CreateOrderRequest;
use App\Domains\Order\Application\Services\CreateOrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $createOrderService;

    public function __construct(CreateOrderService $createOrderService)
    {
        $this->createOrderService = $createOrderService;
    }

    public function create(Request $request)
    {
        $dto = new CreateOrderRequest(
            $request->input('product_id'),
            $request->input('quantity'),
            $request->input('user_email')
        );

        $order = $this->createOrderService->execute(
            $dto->productId,
            $dto->quantity,
            $dto->userEmail
        );

        return response()->json([
            'message' => 'Đặt hàng thành công! Email xác nhận đã được gửi.',
            'order_id' => $order->getId()
        ], 201);
    }
}