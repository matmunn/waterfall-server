<?php

namespace App\Console;

use Carbon\Carbon;
use App\Console\Commands\UpdateAvailable;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\UpdateRecurringTasks;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        UpdateRecurringTasks::class,
        UpdateAvailable::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $now = new Carbon();
        $schedule->command('db:backup --database=mysql --destination=s3 --destinationPath=/'. $now->year . '/' . $now->year.'-'.$now->month.'-'.$now->day .' --compression=gzip')
            ->dailyAt('00:30');

        $schedule->command('waterfall:update-recurring')
            ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
