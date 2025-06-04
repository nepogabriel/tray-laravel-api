<?php

namespace App\Http\Controllers;

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

        return response()->json([
            'success' => $sales['success'],
            'data' => $sales['data'],
            'message' => $sales['message'],
        ], $sales['code']);
    }

    public function register(SaleRequest $request): JsonResponse
    {
        $sale = $this->saleService->register($request->validated());

        return response()->json([
            'success' => $sale['success'],
            'data' => $sale['data'],
            'message' => $sale['message'],
        ], $sale['code']);
    }

    public function find(int $seller_id): JsonResponse
    {
        $sale = $this->saleService->findById($seller_id);

        return response()->json([
            'success' => $sale['success'],
            'data' => $sale['data'],
            'message' => $sale['message'],
        ], $sale['code']);
    }
}
