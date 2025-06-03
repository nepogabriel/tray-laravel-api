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
}