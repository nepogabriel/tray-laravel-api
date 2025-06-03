<?php

namespace App\Services;

use App\Repositories\SellerRepository;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SellerService
{
    public function __construct(
        private SellerRepository $sellerRepository
    ) {}

    public function create(array $seller): array
    {
        try {
            $seller = $this->sellerRepository->create($seller);

            Log::info('Vendedor criado com sucesso', [
                'seller_id' => $seller->id,
                'name' => $seller->name,
                'email' => $seller->email
            ]);

            return [
                'success' => true,
                'data' => $seller,
                'message' => 'Vendedor cadastrado com sucesso.',
                'code' => Response::HTTP_CREATED,
            ];
        } catch (\Exception $exception) {
            Log::error('Erro ao criar vendedor: ' . $exception->getMessage(), [
                'request_data' => $seller
            ]);
            
            return [
                'success' => false,
                'data' => [],
                'message' => 'Erro ao cadastrar vendedor.',
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ];
        }
    }

    public function findAll()
    {
        try {
            $sellers = $this->sellerRepository->findAll();

            return [
                'success' => true,
                'data' => $sellers,
                'message' => 'Vendedores listados com sucesso.',
                'code' => Response::HTTP_OK,
            ];
        } catch (\Exception $exception) {
            Log::error('Erro ao listar vendedores: ' . $exception->getMessage());
            
            return [
                'success' => false,
                'data' => [],
                'message' => 'Erro ao listar vendedores.',
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ];
        }
    }
}