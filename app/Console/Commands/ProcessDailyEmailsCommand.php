<?php

namespace App\Console\Commands;

use App\Services\SaleService;
use Illuminate\Console\Command;

class ProcessDailyEmailsCommand extends Command
{
    protected $signature = 'sales:process-daily-emails';

    protected $description = 'Processar fila de e-mails diários de vendas';

    public function handle(SaleService $saleService)
    {
        $this->info('Processando emails diários...');
        
        $count = $saleService->processDailyEmails();
        
        $this->info("$count emails adicionados à fila de processamento.");
    }
}
