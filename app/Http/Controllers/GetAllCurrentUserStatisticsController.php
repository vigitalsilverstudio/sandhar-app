<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PHPClass\CreateData;
use App\CurrentUserStatistic;
use App\UserProduct;

class GetAllCurrentUserStatisticsController extends Controller{
  
  public function get_all_current_user_statistics(Request $request){
    
    if(isset($request->query()['page']) == true){
      $current_user_statistics = CurrentUserStatistic::paginate(50);
    }
    
    else{
      $current_user_statistics = CurrentUserStatistic::all();
    }
    
    $current_user_statistics_object = [
      'current_user_statistics' => $current_user_statistics,
    ];
    
    return response()->json(CreateData::create_data($current_user_statistics_object));
  }
}
