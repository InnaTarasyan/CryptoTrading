<?php

namespace App\Console\Commands\CoinMarketCap;

use App\Library\Services\CoinMarketService;
use Illuminate\Console\Command;

class OhlcvHistorical extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coinmarketcap:ohlcv-historical';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'coinmarketcap api v2 /ohlcv/historical';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(CoinMarketService $service)
    {
        $service->ohlcvHistorical();
    }
}
