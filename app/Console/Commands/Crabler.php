<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Library\Services\CoinMarketCalService;
use App\Library\Services\LiveCoinWatch;
use App\Library\Services\CoinGeckoService;
use Illuminate\Support\Facades\Log;

class Crabler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:crabler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates all data of site';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {

            Log::channel('crabler')->info('CoinMarketCalService::coins()');
            CoinMarketCalService::coins();
            sleep(60);

            Log::channel('crabler')->info('CoinMarketCalService::events()');
            CoinMarketCalService::getEvents();
            sleep(60);

            $coinGeckoService = new CoinGeckoService();
            $coinGeckoService->handle();

            Log::channel('crabler')->info('LiveCoinWatch::getHistory()');
            LiveCoinWatch::getHistory();
            sleep(60);


        } catch (\Exception $exception) {
            $status = 'fail';
        }

    }
}
