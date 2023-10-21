<?php

namespace App\Console\Commands\CoinMarketCap;

use App\Library\Services\CoinMarketService;
use Illuminate\Console\Command;

class PricePerformanceStatsLatest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coinmarketcap:price-performance-stats-latest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'coinmarketcap api v2 /price-performance-stats/latest';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(CoinMarketService $service)
    {
        $service->pricePerformanceStatsLatest();
    }
}
