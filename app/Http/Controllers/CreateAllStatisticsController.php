<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PHPClass\CreateAllCurrentStatistics;

use App\CurrentStatistic;
use App\Statistic;

class CreateAllStatisticsController extends Controller{
    
	public function create_all_statistics(){
		
		CreateAllCurrentStatistics::create_all_current_statistics();
		
		$current_statistics = CurrentStatistic::all();
		
		for($n = 0; $n < count($current_statistics); $n++){			
			Statistic::create($current_statistics[$n]->toArray());
		}			
	}
}
