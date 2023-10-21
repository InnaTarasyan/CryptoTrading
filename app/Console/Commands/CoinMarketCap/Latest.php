<?php

namespace App\Console\Commands\CoinMarketCap;

use Illuminate\Console\Command;
use App\Library\Services\CoinMarketService;


class Latest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coinmarketcap:latest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Coinmarketcap latest';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(CoinMarketService $service)
    {
        $service->latest();
    }
}
