<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PHPClass\CreateData;

use App\CurrentStatistic;
use App\CurrentUserStatistic;
use App\Product;

use App\PHPClass\CreateAllCurrentStatistics;

class GetAllCurrentStatisticsController extends Controller{
    
  public function get_all_current_statistics(Request $request){
    
    CreateAllCurrentStatistics::create_all_current_statistics();
    
    if(isset($request->query()['page']) == true){
      $current_statistics = CurrentStatistic::paginate(50);
    }
    
    else{
      $current_statistics = CurrentStatistic::all();
    }
    
    $current_statistics_object = [
      'current_statistics' => $current_statistics,
    ];
    
    
    return response()->json(CreateData::create_data($current_statistics_object));
    
  }  
}
