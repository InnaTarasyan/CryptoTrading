<?php

namespace App\Console\Commands\CoinMarketCap;

use App\Library\Services\CoinMarketService;
use Illuminate\Console\Command;

class QuotesHistoricalV1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coinmarketcap:quotes-historical-v1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'coinmarketcap api /quotes/historical';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(CoinMarketService $service)
    {
        $service->quotesHistoricalV1();
    }
}
