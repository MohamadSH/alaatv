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
    protected $commands = [//
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /*$schedule->command('telescope:prune --hours=48')
            ->daily();*/
        $schedule->command('horizon:snapshot')
            ->everyFiveMinutes();

//        $schedule->command('backup:mysql-dump')
//            ->timezone('Asia/Tehran')
//            ->dailyAt('04:30');

        $schedule->command('alaaTv:employee:send:timeSheet 0')
            ->dailyAt('23:45')
            ->timezone('Asia/Tehran');

        $schedule->command('alaaTv:employee:check:overtime:confirmation')
            ->dailyAt('00:05')
            ->timezone('Asia/Tehran');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
