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

    public function findBySellerId($seller_id): Collection
    {
        return Sale::where('seller_id', $seller_id)->get();
    }

    public function getSales($seller_id): Collection
    {
        return Sale::where('seller_id', $seller_id)
            ->whereDate('sale_date', now()->format('Y-m-d'))
            ->get();
    }

    public function getSalesToday(): Collection
    {
        return Sale::whereDate('sale_date', now()->format('Y-m-d'))->get();
    }
}
