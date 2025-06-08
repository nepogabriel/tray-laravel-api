<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\SellerRequest;
use App\Services\SellerService;
use Illuminate\Http\JsonResponse;

class SellerController extends Controller
{
    public function __construct(
        private SellerService $sellerService
    ) {}
    public function index(): JsonResponse
    {
        $sellers = $this->sellerService->findAll();

        return ApiResponse::response($sellers);
    }

    public function create(SellerRequest $request): JsonResponse
    {
        $seller = $this->sellerService->create($request->validated());

        return ApiResponse::response($seller);
    } 
}
