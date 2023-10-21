<?php

namespace App\Console\Commands\CoinMarketCap;

use App\Library\Services\CoinMarketService;
use Illuminate\Console\Command;

class PricePerformanceStatsLatestV1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coinmarketcap:price-performance-stats-latest-v1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'coinmarketcap api /price-performance-stats/latest';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(CoinMarketService $service)
    {
        $service->pricePerformanceStatsLatestV1();
    }
}
