<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Library\Services\WorldCoinIndexService;

class WorldCoinIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'worldcoinindex:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle(WorldCoinIndexService $service)
    {
        $service->get();
    }
}
