<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Jobs\RandomUserJob;
use App\Jobs\DailyRecordJob;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new RandomUserJob)->hourly();
        $schedule->job(new DailyRecordJob)->daily()->withoutOverlapping();

        // $schedule->job(new RandomUserJob)->everyTwoSeconds();
        // $schedule->job(new DailyRecordJob)->everyThirtySeconds()->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
