<?php

namespace App\Console\Commands\CoinMarketCap;

use App\Library\Services\CoinMarketService;
use Illuminate\Console\Command;

class Categories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comarketcap:categories {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'coinmarketcap Categories';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(CoinMarketService $service)
    {
        $id = $this->option('id');
        if ($id) {
            $service->category($id);
            return Command::SUCCESS;
        }

        $service->categories();
    }
}
