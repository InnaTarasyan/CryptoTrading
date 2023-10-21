<?php

namespace App\Console\Commands\CoinMarketCap;

use App\Library\Services\CoinMarketService;
use Illuminate\Console\Command;

class QuotesLatestPartner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coinmarketcap:listings-latest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'coinmarketcap api /partners/flipside-crypto/fcas/quotes/latest';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(CoinMarketService $service)
    {
        $service->quotesLatestPartner();
    }
}
