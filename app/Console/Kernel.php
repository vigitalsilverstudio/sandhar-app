<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;


use App\CurrentStatistic;
use App\CurrentUserStatistic;
use App\UserProduct;

use App\Http\Controllers\CreateAllStatisticsController;
use App\Http\Controllers\CreateAllUserStatisticsController;
use App\Http\Controllers\UpdateCurrentUserStatisticController;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [        
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
    $schedule->call(function () {
            
      $create_all_statistics = new CreateAllStatisticsController();
      $create_all_statistics->create_all_statistics();
      
      $create_all_user_statistics = new CreateAllUserStatisticsController();
      $create_all_user_statistics->create_all_user_statistics();
      
      CurrentStatistic::getQuery()->delete();
      CurrentUserStatistic::getQuery()->delete();
      UserProduct::getQuery()->delete();
      
        })->daily();
    
    
    $schedule->call(function(){
      
      $new_hour = new UpdateCurrentUserStatisticController();
      $new_hour->new_hour();
      
    })->hourly();
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
