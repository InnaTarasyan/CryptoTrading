<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Library\Services\LiveCoinWatch;
use Illuminate\Support\Facades\Log;

class LiveCoinFiats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:live-coin-fiats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Live Coin Fiats';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::channel('crabler')->info('LiveCoinWatch::getFiats()');
        LiveCoinWatch::getFiats();
    }
}
