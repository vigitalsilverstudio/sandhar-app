<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\CurrentUserStatistic;
use App\UserStatistic;

class CreateAllUserStatisticsController extends Controller{
    
	public function create_all_user_statistics(){
			
		$current_user_statistics = CurrentUserStatistic::all();
		
		for($n = 0; $n < count($current_user_statistics); $n++){			
			UserStatistic::create($current_user_statistics[$n]->toArray());
		}			
	}
}
