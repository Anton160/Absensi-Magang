<?php

namespace App\Console;

use App\Jobs\AutoAttendance;
use App\Jobs\AutoCheckout;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        // cron adalah format waktunya yang pertama adalah indikator menit berapa
        // yang kedua adalah indikator jam berapa
        // sisanya mengatur tanggal bulan dan tahun
        $schedule->job(new AutoAttendance)->cron('01 12 * * *');
        $schedule->job(new AutoCheckout)->cron('30 18 * * *');
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
