<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\PHPClass\CreateData;
use App\PHPClass\CreateError;

use App\CurrentStatistic;

class GetCurrentStatisticController extends Controller{
    
	public function get_current_statistic($product_id){
		
		try{
			$current_statistic = CurrentStatistic::where('product_id', $product_id)->firstOrFail();
			
			$current_statistic_object = [
				'current_statistic' => $current_statistic,
			];
			
			return response()->json(CreateData::create_data($current_statistic_object));
		}
		
		catch(ModelNotFoundException $e){
			return CreateError::create_error(['Podany produkt nie istnieje']);
		}
			
	}
}
