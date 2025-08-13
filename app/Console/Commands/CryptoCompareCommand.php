<?php

namespace App\Console\Commands;

use App\Library\Services\CryptoCompareService;
use Illuminate\Console\Command;

class CryptoCompareCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cryptocompare:fetch {--single : Fetch only market data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch data from CryptoCompare API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting CryptoCompare data fetch...');
        
        $service = new CryptoCompareService();
        
        if ($this->option('single')) {
            $this->info('Fetching single market data...');
            $service->handleSingle();
        } else {
            $this->info('Fetching all data...');
            $service->handle();
        }
        
        $this->info('CryptoCompare data fetch completed!');
    }
} 