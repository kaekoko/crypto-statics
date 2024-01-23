<?php

namespace App\Console;

use Spatie\ShortSchedule\ShortSchedule;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('custom:reset')->dailyAt('00:01')->timezone('Asia/Yangon');
        $schedule->command('list:reset')->dailyAt('00:02')->timezone('Asia/Yangon');
        // $schedule->command('sat:sun')->dailyAt('00:05')->timezone('Asia/Yangon');
    }

    protected function shortSchedule(\Spatie\ShortSchedule\ShortSchedule $shortSchedule)
    {
        $shortSchedule->command('live:cron')->everySeconds(5)->withoutOverlapping(10);
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
