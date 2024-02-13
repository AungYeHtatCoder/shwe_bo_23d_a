<?php

namespace App\Console;

use Illuminate\Support\Facades\DB;
use App\Jobs\CheckForEveningWinners;
use App\Jobs\CheckForMorningWinners;
use App\Jobs\CheckForEarlyEveningWinners;
use App\Jobs\CheckForEarlyMonringWinners;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
{
    $schedule->job(new CheckForEarlyMonringWinners)->dailyAt('9:30');
    $schedule->job(new CheckForMorningWinners)->dailyAt('12:00');
    $schedule->job(new CheckForEarlyEveningWinners)->dailyAt('2:30');
    $schedule->job(new CheckForEveningWinners)->dailyAt('16:30');
    


}

    // protected function schedule(Schedule $schedule): void
    // {
    //     // $schedule->command('inspire')->hourly();
    // //     $schedule->call(function () {
    // //     DB::table('lottery_two_digit_pivot')
    // //         ->join('lotteries', 'lotteries.id', '=', 'lottery_two_digit_pivot.lottery_id')
    // //         ->where('lotteries.session', 'morning')
    // //         ->delete();
    // // })->dailyAt('12:00');
    //  $schedule->job(new CheckForMorningWinners)->dailyAt('12:00');
    // $schedule->job(new CheckForEveningWinners)->dailyAt('16:30');
    // }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}