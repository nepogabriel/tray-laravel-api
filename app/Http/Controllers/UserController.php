<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\UserRequest;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    public function register(UserRequest $request)
    {
        $user = $this->userService->register($request->validated());

        return ApiResponse::response($user);
    }
}
