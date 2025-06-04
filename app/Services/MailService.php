<?php

namespace App\Services;

use App\Mail\DailySalesEmail;
use App\Mail\DailySalesToAdminEmail;
use App\Repositories\SaleRepository;
use App\Repositories\SellerRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailService
{
    private SaleRepository $saleRepository;
    private SellerRepository $sellerRepository;
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->saleRepository = new SaleRepository();
        $this->sellerRepository = new SellerRepository();
        $this->userRepository = new UserRepository();
    }

    public function processDailyEmails(): int
    {
        try {
            $sellerList = $this->sellerRepository->findAll();

            foreach ($sellerList as $index => $seller) {
                $sales = $this->saleRepository->getSales($seller->id);

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

    public function processDailyEmailsBySellerId(int $seller_id): int
    {
        try {
            $seller = $this->sellerRepository->findById($seller_id);

            $sales = $this->saleRepository->getSales($seller->id);

            $data = [
                'total_sales' => $sales->count(),
                'total_value' => $sales->sum('value'),
                'total_commission' => $sales->sum('commission'),
                'date' => now()->format('Y-m-d'),
            ];

            $email = new DailySalesEmail($seller, $data);

            $when = now()->addSeconds(15);
            Mail::to($seller)->later($when, $email);

            Log::info('Fila processada com sucesso!');

            return 1;
        } catch (\Exception $exception) {
            Log::error('Erro ao processar fila de e-mail para um vendedor: ' . $exception->getMessage());
            return 0;
        }
    }

    public function processDailyEmailsToAdmin(): int
    {
        try {
            $userList = $this->userRepository->findAll();

            foreach ($userList as $index => $user) {
                $sales = $this->saleRepository->getSalesToday();

                $data = [
                    'total_sales' => $sales->count(),
                    'total_value' => $sales->sum('value'),
                    'total_commission' => $sales->sum('commission'),
                    'date' => now()->format('Y-m-d'),
                ];

                $email = new DailySalesToAdminEmail($user, $data);

                $when = now()->addSeconds( $index * 5);
                Mail::to($user)->later($when, $email);
            }

            Log::info('Fila processada com sucesso!');

            return 1;
        } catch (\Exception $exception) {
            Log::error('Erro ao processar fila de e-mail para o administrador: ' . $exception->getMessage());
            return 0;
        }
    }
}
