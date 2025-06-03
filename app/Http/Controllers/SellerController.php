<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellerRequest;
use App\Services\SellerService;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function __construct(
        private SellerService $sellerService
    ) {}
    public function index()
    {
        return ['tudo bem'];
    }

    public function create(SellerRequest $request)
    {
        $seller = $this->sellerService->create($request->validated());

        return response()->json([
            'success' => $seller['success'],
            'data' => $seller['data'],
            'message' => $seller['message'],
        ], $seller['code']);
    } 
}
