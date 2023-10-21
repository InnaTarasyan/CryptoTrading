<?php

namespace App\Console\Commands\CoinMarketCap;

use App\Library\Services\CoinMarketService;
use Illuminate\Console\Command;

class QuotesLatestV1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coinmarketcap:quotes-latest-v1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'coinmarketcap api /quotes/latest';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(CoinMarketService $service)
    {
        $service->quotesLatestV1();
    }
}
