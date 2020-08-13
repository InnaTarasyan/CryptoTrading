<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Library\Services\CoindarSocialsService;

class ImportCoindarSocialis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coindar-socials:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports data from Coidar.org API, Возвращает данные о социальных сетях криптовалют.';

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
    public function handle(CoindarSocialsService $service)
    {
        $service->get();
    }
}
