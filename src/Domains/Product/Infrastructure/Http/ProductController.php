<?php

namespace App\Domains\Product\Infrastructure\Http\Controllers;

use App\Domains\Product\Application\Dtos\AddReviewRequest;
use App\Domains\Product\Application\Dtos\CreateProductRequest;
use App\Domains\Product\Application\Services\AddReviewService;
use App\Domains\Product\Application\Services\ApplyPromotionService;
use App\Domains\Product\Application\Services\CreateProductService;
use App\Domains\Product\Application\Services\GetProductDetailService;
use App\Domains\Product\Application\Services\GetProductReviewsService;
use App\Domains\Product\Application\Services\GetRecommendedProductsService;
use App\Domains\Product\Application\Services\GetUserViewedProductsService;
use App\Domains\Product\Application\Services\SearchProductsService;
use App\Domains\Product\Application\Services\GetProductStatisticsService;
use App\Domains\Product\Application\Services\GetProductPurchaseQuantityService;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    private   $createService;
    private   $detailService;
    private   $searchService;
    private   $statsService;
    private   $purchaseQtyService;
    private   $userViewedService;
    private   $getProductReviewsService;
    protected $addReviewService;
    private   $getRecommendedProductsService;
    private   $applyPromotionService;

    public function __construct(
        CreateProductService              $createService,
        GetProductDetailService           $detailService,
        SearchProductsService             $searchService,
        GetProductStatisticsService       $statsService,
        GetProductPurchaseQuantityService $purchaseQtyService,
        GetUserViewedProductsService      $userViewedService,
        ApplyPromotionService             $applyPromotionService,
        AddReviewService                  $addReviewService,
        GetProductReviewsService          $getProductReviewsService,
        GetRecommendedProductsService     $getRecommendedProductsService
    ) {
        $this->createService                 = $createService;
        $this->detailService                 = $detailService;
        $this->searchService                 = $searchService;
        $this->statsService                  = $statsService;
        $this->purchaseQtyService            = $purchaseQtyService;
        $this->userViewedService             = $userViewedService;
        $this->applyPromotionService         = $applyPromotionService;
        $this->addReviewService              = $addReviewService;
        $this->getProductReviewsService      = $getProductReviewsService;
        $this->getRecommendedProductsService = $getRecommendedProductsService;
    }

    public function create(Request $request)
    {
        $dto = new CreateProductRequest(
            $request->input('name'),
            $request->input('price'),
            $request->input('category')
        );

        $product = $this->createService->execute($dto->name, $dto->price, $dto->category);

        return response()->json(['message' => 'Sản phẩm đã thêm', 'id' => $product->getId()]);
    }

    public function detail($id)
    {
        $product = $this->detailService->execute($id);

        return response()->json($product);
    }

    public function search(Request $request)
    {
        $query    = $request->input('query');
        $products = $this->searchService->execute($query);

        return response()->json($products);
    }

    public function statistics()
    {
        $stats = $this->statsService->execute();

        return response()->json($stats);
    }

    public function purchaseQuantity($productId)
    {
        $quantity = $this->purchaseQtyService->execute($productId);

        return response()->json(['product_id' => $productId, 'quantity_sold' => $quantity]);
    }

    public function userViews($userId)
    {
        $viewedProducts = $this->userViewedService->execute($userId);
        return response()->json([
            'user_id' => $userId,
            'viewed_products' => $viewedProducts
        ]);
    }

    public function applyPromotion($id, Request $request)
    {
        $this->applyPromotionService->execute($id, $request->discount, $request->start_date, $request->end_date);
        return response()->json(['message' => 'Áp dụng khuyến mãi thành công']);
    }


    public function addReview($id, Request $request)
    {
        $dto = new AddReviewRequest(
            $request->input('user_id'),
            $id,
            $request->input('rating'),
            $request->input('comment')
        );

        $review = $this->addReviewService->execute(
            $dto->userId,
            $dto->productId,
            $dto->rating,
            $dto->comment
        );

        return response()->json(['message' => 'Đánh giá đã thêm', 'review_id' => $review->getId()]);
    }

    public function getReviews($id)
    {
        $reviews = $this->getProductReviewsService->execute($id);
        return response()->json($reviews);
    }


    public function getRecommendations($userId)
    {
        $recommended = $this->getRecommendedProductsService->execute($userId);
        return response()->json($recommended);
    }

}