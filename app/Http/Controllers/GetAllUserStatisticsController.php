<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\UserStatistic;
use App\PHPClass\CreateData;

class GetAllUserStatisticsController extends Controller{
    
  public function get_all_user_statistics(Request $request){
    
    if(isset($request->query()['page']) == true){
      $user_statistics = UserStatistic::paginate(50);
    }
    
    else{
      $user_statistics = UserStatistic::all();
    }
    
    $user_statisitcs_object = [
      'user_statistics' => $user_statistics,
    ];
    
    return response()->json(CreateData::create_data($user_statisitcs_object));
  }
}
