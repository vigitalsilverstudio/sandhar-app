<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PHPClass\CreateData;
use App\Statistic;

class GetAllStatisticsController extends Controller{
    
  public function get_all_statistics(Request $request){
    
    if(isset($request->query()['page']) == true){
      $statisitcs = Statistic::paginate(50);
    }
    
    else{
      $statisitcs = Statistic::all();
    }
    
    $statisitcs_object = [
      'statistics' => $statisitcs,
    ];
    
    return response()->json(CreateData::create_data($statisitcs_object));
  }
}
