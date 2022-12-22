<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\PHPClass\CreateData;
use App\PHPClass\CreateError;

use App\Product;
use App\User;
use App\UserProduct;
use App\CurrentUserStatistic;

class GetCurrentUserStatisticController extends Controller{
    
	public function get_current_user_statistic($product_id, $login){
		
		try{
			$current_user_statistic = CurrentUserStatistic::where('product_id', $product_id)->where('username', $login)->firstOrFail();
			
			$current_user_statistic_object = [
				'current_user_statistic' => $current_user_statistic,
			];
			
			return response()->json(CreateData::create_data($current_user_statistic_object));
		}
		
		catch(ModelNotFoundException $e){
			
			try{
				$product = Product::where('product_id', $product_id)->firstOrFail();
			}
			
			catch(ModelNotFoundException $e){
				return CreateError::create_error(['Podany produkt nie istnieje']);
			}
			
			try{
				$user = User::where('username', $login)->firstOrFail();
			}
			
			catch(ModelNotFoundException $e){
				return response()->json(CreateError::create_error(['Podany użytkownik nie istnieje']));
			}
			
			
			$user_product = new UserProduct($product->toArray());
			$user_product['username'] = $login;
			$user_product->save();
			
			$current_user_statistic = new CurrentUserStatistic();
            $current_user_statistic->fill($user_product->toArray());  
			$current_user_statistic->save();
			
            $current_user_statistic = CurrentUserStatistic::where('product_id', $product_id)->where('username', $login)->firstOrFail();
            
			$current_user_statistic_object = [
				'current_user_statistic' => $current_user_statistic,
			];
			
			return response()->json(CreateData::create_data($current_user_statistic_object));
		}
			
	}
}
