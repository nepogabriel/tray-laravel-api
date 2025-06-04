<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Seller extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
