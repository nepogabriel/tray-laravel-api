<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'value',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
