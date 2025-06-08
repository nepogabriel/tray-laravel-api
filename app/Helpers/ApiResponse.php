<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{

    public static function response(array $data): JsonResponse
    {
        if (!$data['success'])
            return self::error($data['data'], $data['message'], $data['code']);

        return self::success($data['data'], $data['message'], $data['code']);
    }

    public static function success(mixed $data = [], string $message = '', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $code);
    }

    public static function error(mixed $data = [], string $message = '', int $code = 500): JsonResponse
    {
        return response()->json([
            'success' => false,
            'data' => $data,
            'message' => $message,
        ], $code);
    }
}