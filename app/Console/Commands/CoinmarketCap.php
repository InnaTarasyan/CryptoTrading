<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Library\Services\CoinMarketService;


class CoinmarketCap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coinmarketcap:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'retrieves data from coinmarketcap.com';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(CoinMarketService $service)
    {
        $service->get();
    }
}
