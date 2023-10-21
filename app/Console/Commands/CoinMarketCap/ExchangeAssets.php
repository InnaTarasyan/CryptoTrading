<?php

namespace App\Console\Commands\CoinMarketCap;

use App\Library\Services\CoinMarketService;
use Illuminate\Console\Command;

class ExchangeAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coinmarketcap:exchange-assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'coinmarketcap api exchangeAssets';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(CoinMarketService $service)
    {
        $service->exchangeAssets();
    }
}
