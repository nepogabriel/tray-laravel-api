<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UserService
{
    public function __construct(
        private UserRepository $userRepository
    ) {}
    public function register($user): array
    {
        try {
            $user = $this->userRepository->register($user);

            Log::info('Vendedor criado com sucesso', [
                'seller_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ]);

            return [
                'success' => true,
                'data' => $user,
                'message' => 'Vendedor cadastrado com sucesso.',
                'code' => Response::HTTP_CREATED,
            ];
        } catch (\Exception $exception) {
            Log::error('Erro ao criar vendedor: ' . $exception->getMessage());

            return [
                'success' => false,
                'data' => [],
                'message' => 'Erro ao cadastrar vendedor.',
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ];
        }
    }
}
