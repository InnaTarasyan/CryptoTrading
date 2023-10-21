<?php

namespace App\Console\Commands\CoinMarketCap;

use App\Library\Services\CoinMarketService;
use Illuminate\Console\Command;

class OhlcvLatestV1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coinmarketcap:ohlcv-latest-v1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'coinmarketcap api /ohlcv/latest';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(CoinMarketService $service)
    {
        $service->ohlcvLatestV1();
    }
}
