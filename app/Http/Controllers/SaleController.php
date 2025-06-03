<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Services\SaleService;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function __construct(
        private SaleService $saleService
    ) {}

    public function index()
    {
        return ['tudo bem'];
    }

    public function register(SaleRequest $request)
    {
        $sale = $this->saleService->register($request->validated());

        return response()->json([
            'success' => $sale['success'],
            'data' => $sale['data'],
            'message' => $sale['message'],
        ], $sale['code']);
    }
}
