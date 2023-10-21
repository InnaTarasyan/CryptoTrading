<?php

namespace App\Console\Commands\CoinMarketCap;

use App\Library\Services\CoinMarketService;
use Illuminate\Console\Command;

class ExchangeListingLatest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coinmarketcap:exchange-listings-latest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'coinmarketcap api exchange/listings/latest';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(CoinMarketService $service)
    {
        $service->exchangeListingLatest();
    }
}
