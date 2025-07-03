<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\SendScheduledMail;
use App\Jobs\SendScheduledMailResSuper;
use App\Models\User;

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
        // $schedule->command('inspire')->hourly();
        $users = User::role('TECNICO')->get();
        // $users = [];
        $schedule->job(new SendScheduledMail($users))->weekly();
        // $schedule->job(new SendScheduledMail($users))->dailyAt('17:00');

        $userPrue = User::role('SUPERVISOR')->get();
        // $schedule->job(new SendScheduledMailResSuper($userPrue))->dailyAt('17:00');
        $schedule->job(new SendScheduledMailResSuper($userPrue))->weekly();
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
