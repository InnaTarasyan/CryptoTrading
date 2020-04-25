<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\CoinmarketCap',
        'App\Console\Commands\Coindar',
        'App\Console\Commands\Coinbin',
        'App\Console\Commands\Solume',
        'App\Console\Commands\WorldCoinIndex',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//         $schedule->command('coinbin:start')
//                  ->hourly();

//         $schedule->command('coindar:start')
//                  ->hourly();

         $schedule->command('coinmarketcap:start')
                  ->hourly();

//         $schedule->command('solume:start')
//                  ->hourly();

         $schedule->command('worldcoinindex:start')
                  ->hourly();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
