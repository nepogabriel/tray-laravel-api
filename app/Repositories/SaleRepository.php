<?php

namespace App\Repositories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Collection;

class SaleRepository
{
    public function register(array $sale): Sale
    {
        return Sale::create($sale);
    }

    public function findAll(): Collection
    {
        return Sale::all();
    }

    public function findById(int $sale_id): Sale
    {
        return Sale::findOrFail($sale_id);
    }

    public function getSales($seller_id): Collection
    {
        return Sale::where('seller_id', $seller_id)
            ->whereDate('sale_date', now()->format('Y-m-d'))
            ->get();
    }
}
