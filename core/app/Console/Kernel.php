<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

use App\Terceros;
use App\Mail\CursoMD;

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

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('emp:contrato')->dailyAt('08:00');
        $schedule->command('emp:cumpleaños')->dailyAt('08:00');
        $schedule->command('emp:CarneVacunacion')->monthlyOn(20, '08:00');
        $schedule->command('emp:CarneAlimentos')->monthlyOn(20, '08:00');
        $schedule->command('emp:enviarCA')->dailyAt('08:00');
         $schedule->command('emp:enviarMD')->dailyAt('08:00');
         $schedule->command('emp:enviarBPM')->everyMinute();
//         $schedule->call(function () {
       
// })->everyMinute();

       
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
