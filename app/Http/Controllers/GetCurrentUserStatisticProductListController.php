<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\PHPClass\CreateData;
use App\PHPClass\CreateError;

use App\CurrentuserStatistic;

class GetCurrentUserStatisticProductListController extends Controller{
    
	public function get_current_user_statistic_product_list($product_id){
		
		try{
			$current_user_statistic = CurrentUserStatistic::where('product_id', $product_id)->get();
			
			$current_user_statistic_object = [
				'current_user_statistics' => $current_user_statistic,
			];
			
			return response()->json(CreateData::create_data($current_user_statistic_object));
		}
		
		catch(ModelNotFoundException $e){
			return CreateError::create_error(['Podany produkt użytkownika nie istnieje']);
		}
			
	}
}
