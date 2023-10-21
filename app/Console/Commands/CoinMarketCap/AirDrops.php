<?php

namespace App\Console\Commands\CoinMarketCap;

use App\Library\Services\CoinMarketService;
use Illuminate\Console\Command;

class AirDrops extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comarketcap:airdrops';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'coinmarketcap AirDrops';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(CoinMarketService $service)
    {
       $service->airDrops();
    }
}
