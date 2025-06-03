<?php

namespace App\Repositories;

use App\Models\Seller;

class SellerRepository
{
    public function create(array $seller): Seller
    {
        return Seller::create($seller);
    }
}