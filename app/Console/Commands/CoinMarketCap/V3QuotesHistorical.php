<?php

namespace App\Console\Commands\CoinMarketCap;

use App\Library\Services\CoinMarketService;
use Illuminate\Console\Command;

class V3QuotesHistorical extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coinmarketcap:v3-quotes-historical';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'coinmarketcap api v3 /quotes/historical';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(CoinMarketService $service)
    {
        $service->quotesHistoricalV3();
    }
}
