<?php

namespace App\Console;

use App\Console\Commands\Crabler;
use App\Console\Commands\LiveCoinCoins;
use App\Console\Commands\LiveCoinFiats;
use App\Console\Commands\LiveCoinHistory;
use App\Console\Commands\LiveCoinWatch;
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
        Crabler::class,
        LiveCoinCoins::class,
        LiveCoinWatch::class,
        LiveCoinHistory::class,
        LiveCoinFiats::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('app:crabler')->everyTwoDays();

        $schedule->command('app:live-coin-coins')->weeklyOn(2, '09:00');

        $schedule->command('app:live-coin-exchanges')->weeklyOn(3, '12:00');

        $schedule->command('app:live-coin-fiats')->weeklyOn(4, '14:00');

        $schedule->command('app:live-coin-history')->weeklyOn(5, '14:00');
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
