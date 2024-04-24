<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Schedule the lotto:fetch command to run on the 1st and 16th of every month at 3:30 pm
        $schedule->command('lotto:fetch')->cron('30 15 1,16 * *'); // 3:30 pm on the 1st and 16th
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

// * * * * * cd /path/to/your/laravel/app && php artisan schedule:run >> /dev/null 2>&1
// php artisan schedule:run
//php artisan lotto:fetch