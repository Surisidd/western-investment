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
        //
    ];


protected function scheduleTimezone()
{
    return 'Africa/Nairobi';
}


    protected function schedule(Schedule $schedule)
    {
        
        $schedule->command('Email:SendHourlyStatements')
                ->everyMinute();	
        // $schedule->command('inspire')->hourly();
    }

  
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
        Commands\SendHourlyStatements::class;

    }
}
