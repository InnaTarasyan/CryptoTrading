<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Library\Services\LiveCoinWatch as LiveCoinWatchService;

class LiveCoinWatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:live-coin-watch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new LiveCoinWatchService();
        $service->handle();
    }
}
