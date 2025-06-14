<?php

namespace App\Repositories;

use App\Models\Seller;
use Illuminate\Database\Eloquent\Collection;

class SellerRepository
{
    public function create(array $seller): Seller
    {
        return Seller::create($seller);
    }

    public function findAll(): Collection
    {
        return Seller::all();
    }

    public function findById(int $seller_id): Seller
    {
        return Seller::findOrFail($seller_id);
    }
}
