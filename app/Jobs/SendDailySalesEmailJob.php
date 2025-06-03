<?php

namespace App\Jobs;

use App\Mail\DailySalesEmail;
use App\Models\Sale;
use App\Models\Seller;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class SendDailySalesEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected int $sellerId
    )
    {
        $this->onQueue('default');
    }

    public function handle(): bool
    {
        $today = now()->format('Y-m-d');
        $queueKey = "send_daily_email_sent:{$this->sellerId}:$today";
        
        if (Redis::exists($queueKey))
            return 1;

        $seller = Seller::find($this->sellerId);

        if (!$seller)
            return 0;

        $sales = Sale::where('seller_id', $this->sellerId)
            ->whereDate('sale_date', $today)
            ->get();

        $data = [
            'total_sales' => $sales->count(),
            'total_value' => $sales->sum('value'),
            'total_commission' => $sales->sum('commission'),
            'date' => $today
        ];

        if ($data['total_sales'] > 0) {
            Mail::to($seller->email)->send(new DailySalesEmail($seller, $data));
        }

        Redis::setex($queueKey, 90000, true);

        return 1;
    }
}
