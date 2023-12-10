<?php

namespace App\Console\Commands;

use App\Library\Services\CoinGeckoService;
use Illuminate\Console\Command;

class GetCoinGeckoData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-coin-gecko-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data from coingecko';

    /**
     * Execute the console command.
     */
    public function handle(CoinGeckoService $service)
    {
        $service->handle();
    }
}
