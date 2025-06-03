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

            $this->queueDailyEmail($sale->seller_id);

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
            $sale = $this->saleRepository->findById($sale_id);

            return [
                'success' => true,
                'data' => $sale,
                'message' => 'Venda encontrada com sucesso.',
                'code' => Response::HTTP_OK,
            ];
        } catch (\Exception $exception) {
            Log::error('Erro ao pesquisar venda por ID: ' . $exception->getMessage());
            
            return [
                'success' => false,
                'data' => [],
                'message' => 'Erro ao pesquisar venda por ID.',
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ];
        }
    }

    public function queueDailyEmail($sellerId): void
    {
        $today = now()->format('Y-m-d');
        $queueKey = "daily_email_queue:$today";

        try{
            Redis::sadd($queueKey, $sellerId);
            Redis::expireat($queueKey, strtotime('tomorrow'));
        } catch (\Exception $exception) {
            Log::error('Erro ao registrar e-mail na fila: ' . $exception->getMessage());
        }
    }

    public function processDailyEmails(): int
    {
        $today = now()->format('Y-m-d');
        $queueKey = "daily_email_queue:$today";

        try{
            $sellerIds = Redis::smembers($queueKey) ?: [];

            if (empty($sellerIds)) {
                Log::info("Nenhum sellerId encontrado na fila $queueKey");
                return 0;
            }

            foreach ($sellerIds as $sellerId) {
                SendDailySalesEmailJob::dispatch($sellerId)
                    ->delay(now()->addMinutes(rand(1, 30)));
            }

            //Redis::del($queueKey);
        
            return count($sellerIds);
        } catch (\Exception $exception) {
            Log::error('Erro ao processar fila de e-mail: ' . $exception->getMessage());
            return 0;
        }
    }
}