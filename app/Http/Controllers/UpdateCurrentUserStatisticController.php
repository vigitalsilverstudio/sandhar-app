<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\CurrentUserStatistic;

use App\PHPClass\CreateError;
use App\PHPClass\CreateData;

use Carbon\Carbon;

class UpdateCurrentUserStatisticController extends Controller
{
    public function update_current_user_statistic(Request $request, $product_id, $login){
		
		try{
			$current_user_statistic = CurrentUserStatistic::where('product_id',$product_id)->where('username',$login)->firstOrFail();
		}
		
		catch(ModelNotFoundException $e){
			return response()->json(CreateError::create_error(['Produkt użytkownika o podanym ID nie istnieje']));
		}
			
		foreach($request->all() as $key => $value){
								
			if($key == 'error'){
				$request['number_of_bad_products'] = $current_user_statistic['number_of_bad_products'] + $value;
				$request['sum_of_products'] = $current_user_statistic['number_of_good_products'] + $request['number_of_bad_products'];					
					
				$current_user_statistic['number_of_bad_products'] = $request['number_of_bad_products'];
				$current_user_statistic['sum_of_products'] = $request['sum_of_products'];
					
				$current_user_statistic->save();
					
				unset($request[$key]);
				unset($request['number_of_bad_products']);
				unset($request['sum_of_products']);
					
				continue;
			}
				
			if($key == 'success'){										
					
				$request['number_of_good_products'] = $request['number_of_good_products'];
				$request['sum_of_products'] = $current_user_statistic['sum_of_products'] + $request[$key];					
					
				$current_user_statistic['number_of_good_products'] = $request['number_of_good_products'];
				$current_user_statistic['sum_of_products'] = $request['sum_of_products'];
										
				$current_user_statistic->save();
					
				unset($request[$key]);
				unset($request['number_of_good_products']);
				unset($request['sum_of_products']);
										
				continue;
			}
							
			if($value != 0 and empty($value) == true){
				$request[$key] = $current_user_statistic[$key];
				$current_user_statistic[$key] = $request[$key];
				$current_user_statistic->save();
			}
				
			if($key == 'attentions' and empty($value)){
				$request[$key] = '';
				$current_user_statistic[$key] = $request[$key];
			}
				
			if($key == 'attentions'){									
				$current_user_statistic['attentions'] = $request[$key];
				$current_user_statistic->save();
				continue;
			}
				
			$current_user_statistic[$key] = $request[$key];						
			$current_user_statistic->save();
		}
														
		return response()->json(CreateData::create_data(['current_user_statistic' => $current_user_statistic]));
	}
	
	public function new_hour(){
		$user_products = CurrentUserStatistic::all();		
		
		$date = Carbon::now();
		
		if(!($date->hour > 6 and $date->hour < 23)){
			return;
		}
				
		for($n = 0; $n < count($user_products); $n++){
			
			$user_product = $user_products[$n];
			
			if($user_product['sum_of_products'] - $user_product['min_production_level'] < 0){
				$user_product['above_min_production_level'] = 'above_min_production_level_error';
			}
				
			if($user_product['sum_of_products'] == 0){
				$user_product['above_min_production_level'] = '';
			}
				
			if($user_product['sum_of_products'] - $user_product['min_production_level'] >= 0){
				$user_product['above_min_production_level'] = '';
			}
			
			$user_product->save();
		}			
	}
}

