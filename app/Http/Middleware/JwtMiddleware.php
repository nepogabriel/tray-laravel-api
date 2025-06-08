<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use Closure;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                $data = [
                    'success' => false,
                    'data' => [],
                    'message' => 'Token de autorização inválido!',
                    'code' => Response::HTTP_UNAUTHORIZED,
                ];

                return ApiResponse::response($data);
            } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                $data = [
                    'success' => false,
                    'data' => [],
                    'message' => 'Token de autorização expirado!',
                    'code' => Response::HTTP_UNAUTHORIZED,
                ];

                return ApiResponse::response($data);
            } else {
                $data = [
                    'success' => false,
                    'data' => [],
                    'message' => 'Token de autorização não encontrado!',
                    'code' => Response::HTTP_UNAUTHORIZED,
                ];

                return ApiResponse::response($data);
            }
        }

        return $next($request);
    }
}
