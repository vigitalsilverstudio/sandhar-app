<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\PHPClass\CreateData;
use App\PHPClass\CreateError;

use App\UserProduct;
use App\CurrentUserStatistic;

class DeleteUserProductController extends Controller{
    
	public function delete_user_product($product_id, $login){
	
		try{
			$user_product = UserProduct::where('product_id', $product_id)->where('username', $login)->firstOrFail();
			$user_product->delete();
			
			$current_user_statistic = CurrentUserStatistic::where('product_id', $product_id)->get();
			
			for($n = 0; $n < count($current_user_statistic); $n++){
				$current_user_statistic[$n]->delete();
			}
			
			return response()->json(CreateData::create_data(['user_product' => $user_product]));
		}
		
		catch(ModelNotFoundException $e){
			return CreateError::create_error(['Podany produkt użytkownika nie istnieje']);
		}
	}
}
