<?php

namespace App\Console\Commands;

use App\Jobs\SendDailySalesEmailJob;
use App\Services\SaleService;
use Illuminate\Console\Command;

class ProcessDailyEmailsCommand extends Command
{
    protected $signature = 'sales:process-daily-emails';

    protected $description = 'Processar fila de e-mails diários de vendas';

    public function handle(SaleService $saleService)
    {
        $this->info('Processando emails diários...');

        SendDailySalesEmailJob::dispatch();

        $this->info("Emails adicionados à fila de processamento.");
    }
}
