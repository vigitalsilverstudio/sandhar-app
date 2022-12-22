<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\PHPClass\CreateData;
use App\PHPClass\CreateError;

use App\Product;
use App\UserProduct;
use App\CurrentStatistic;
use App\CurrentUserStatistic;

class DeleteProductController extends Controller{
    
	public function delete_product($product_id){
		
		try{
			$product = Product::where('product_id', $product_id)->firstOrFail();
			$product->delete();
						
			$user_product = UserProduct::where('product_id', $product_id)->get();
			
			for($n = 0; $n < count($user_product); $n++){
				$user_product[$n]->delete();
			}
			
			$current_statistic = CurrentStatistic::where('product_id', $product_id)->get();
			
			for($n = 0; $n < count($current_statistic); $n++){
				$current_statistic[$n]->delete();
			}
			
			$current_user_statistic = CurrentUserStatistic::where('product_id', $product_id)->get();
			
			for($n = 0; $n < count($current_user_statistic); $n++){
				$current_user_statistic[$n]->delete();
			}
			
			return response()->json(CreateData::create_data(['product' => $product]));
		}
		
		catch(ModelNotFoundException $e){
			return CreateError::create_error(['Podany produkt nie istnieje']);
		}
	}
}
