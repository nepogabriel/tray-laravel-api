<?php

namespace App\Repositories;

use App\Models\Sale;

class SaleRepository
{
    public function register(array $sale): Sale
    {
        return Sale::create($sale);
    }
}