<?php

namespace App\Services;

use App\Jobs\SendDailySalesEmailJob;
use App\Repositories\SaleRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class SaleService
{
    public const COMMISSION = 8.5;

    public function __construct(
        private SaleRepository $saleRepository
    ) {}

    public function register(array $sale): array
    {
        try {
            $value = isset($sale['value']) ? $sale['value'] : 0.0;

            $sale['commission'] = $this->addComission($value);

            $sale = $this->saleRepository->register($sale);

            Log::info('Venda registrada com sucesso.', [
                'sale_id' => $sale->id,
                'seller_id' => $sale->seller_id,
                'value' => $sale->value,
                'sale_date' => $sale->sale_date
            ]);

            return [
                'success' => true,
                'data' => $sale,
                'message' => 'Venda registrada com sucesso.',
                'code' => Response::HTTP_CREATED,
            ];
        } catch (\Exception $exception) {
            Log::error('Erro ao registrar venda: ' . $exception->getMessage());

            return [
                'success' => false,
                'data' => [],
                'message' => 'Erro ao registrar venda.',
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ];
        }
    }

    private function addComission(float $value): float
    {
        return $value * (self::COMMISSION / 100);
    }

    public function findAll(): array
    {
         try {
            $sales = $this->saleRepository->findAll();

            return [
                'success' => true,
                'data' => $sales,
                'message' => 'Vendas listadas com sucesso.',
                'code' => Response::HTTP_OK,
            ];
        } catch (\Exception $exception) {
            Log::error('Erro ao listar as vendas: ' . $exception->getMessage());

            return [
                'success' => false,
                'data' => [],
                'message' => 'Erro ao listar as vendas.',
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ];
        }
    }

    public function findById(int $sale_id): array
    {
        try {
            $sale = $this->saleRepository->findBySellerId($sale_id);

            return [
                'success' => true,
                'data' => $sale,
                'message' => 'Vendas encontrada com sucesso.',
                'code' => Response::HTTP_OK,
            ];
        } catch (\Exception $exception) {
            Log::error('Erro ao pesquisar vendas por ID do vendedor: ' . $exception->getMessage());

            return [
                'success' => false,
                'data' => [],
                'message' => 'Erro ao pesquisar venda por ID.',
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ];
        }
    }
}
