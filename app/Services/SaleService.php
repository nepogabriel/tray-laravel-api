<?php

namespace App\Services;

use App\Repositories\SaleRepository;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SaleService
{
    private const COMMISSION = 8.5;

    public function __construct(
        private SaleRepository $saleRepository
    ) {}

    public function register(array $sale)
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
}