<?php

namespace App\Services;

use App\Mail\DailySalesEmail;
use App\Models\Seller;
use App\Repositories\SaleRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public function __construct(
        private SaleRepository $saleRepository
    ) {}

    public function processDailyEmails(): int
    {
        try {
            $sellerList = Seller::all();

            foreach ($sellerList as $index => $seller) {
                $sales = $this->saleRepository->getSales($seller->id);

                if ($sales->count() <= 0)
                    continue;

                $data = [
                    'total_sales' => $sales->count(),
                    'total_value' => $sales->sum('value'),
                    'total_commission' => $sales->sum('commission'),
                    'date' => now()->format('Y-m-d'),
                ];

                $email = new DailySalesEmail($seller, $data);

                $when = now()->addSeconds( $index * 5);
                Mail::to($seller)->later($when, $email);
            }

            Log::info('Fila processada com sucesso!');

            return 1;
        } catch (\Exception $exception) {
            Log::error('Erro ao processar fila de e-mail: ' . $exception->getMessage());
            return 0;
        }
    }
}
