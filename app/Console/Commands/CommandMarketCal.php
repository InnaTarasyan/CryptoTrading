<?php

namespace App\Console\Commands;

use App\Library\Services\CoinMarketCalService;
use Illuminate\Console\Command;

class CommandMarketCal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:command-market-cal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(CoinMarketCalService $service)
    {
        $service->handle();
    }
}
