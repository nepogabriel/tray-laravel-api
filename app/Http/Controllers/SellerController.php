<?php

namespace App\Http\Controllers;

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

        return response()->json([
            'success' => $sellers['success'],
            'data' => $sellers['data'],
            'message' => $sellers['message'],
        ], $sellers['code']);
    }

    public function create(SellerRequest $request): JsonResponse
    {
        $seller = $this->sellerService->create($request->validated());

        return response()->json([
            'success' => $seller['success'],
            'data' => $seller['data'],
            'message' => $seller['message'],
        ], $seller['code']);
    } 
}
