<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public function findAll(): Collection
    {
        return User::all();
    }

    public function register($user): User
    {
        return User::create($user);
    }
}
