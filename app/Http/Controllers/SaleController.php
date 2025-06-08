<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\SaleRequest;
use App\Services\SaleService;
use Illuminate\Http\JsonResponse;

class SaleController extends Controller
{
    public function __construct(
        private SaleService $saleService
    ) {}

    public function index(): JsonResponse
    {
        $sales = $this->saleService->findAll();

        return ApiResponse::response($sales);
    }

    public function register(SaleRequest $request): JsonResponse
    {
        $sale = $this->saleService->register($request->validated());

        return ApiResponse::response($sale);
    }

    public function find(int $seller_id): JsonResponse
    {
        $sale = $this->saleService->findById($seller_id);

        return ApiResponse::response($sale);
    }
}
