<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Library\Services\LiveCoinWatch;
use Illuminate\Support\Facades\Log;

class LiveCoinHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:live-coin-history';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Live Coin History';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::channel('crabler')->info('LiveCoinWatch::getHistory()');
        LiveCoinWatch::getHistory();
    }
}
