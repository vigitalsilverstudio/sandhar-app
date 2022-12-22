<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\PHPClass\MyValidator;
use App\PHPClass\Sanitizer;

use App\PHPClass\CreateError;
use App\PHPClass\CreateData;
use App\PHPClass\CreateValidationErrors;

use App\User;
use App\Product;
use App\UserProduct;
use App\UserStatistic;
use App\CurrentUserStatistic;

class CreateUserProductController extends Controller{
    
	public function create_user_product(Request $request){
		
		foreach($request->all() as $key => $value){
			$request[$key] = Sanitizer::sanitize($value);
		}
		
		$object = [
			['product_id' => 'App\PHPClass\ProductIDValidator::validate'],			
			['username' => 'App\PHPClass\UsernameValidator::validate'],
		];
		
		$validation_status = MyValidator::validate($object, $request);
		$validation_status = CreateValidationErrors::create_validation_errors($validation_status);
		
		
		if($validation_status != []){
			$user_product_error = CreateError::create_error($validation_status);
			return response()->json($user_product_error);
		}
		
		try{
			$user_product = UserProduct::where('product_id', $request['product_id'])->where('username', $request['username'])->firstOrFail();			
			return CreateError::create_error(['no_validation_error','Podany produkt użytkownika już istnieje']);
		}
		
		catch(ModelNotFoundException $e){
			$product = null;
			$username = null;
			
			try{
				$product = Product::where('product_id', $request['product_id'])->firstOrFail();				
			}
			
			catch(ModelNotFoundException $e){
				return CreateError::create_error(['Podany produkt nie istnieje']);
			}
			
			try{
				$username = User::where('username', $request['username'])->firstOrFail();
				
				$user_product = new UserProduct($product->toArray());
				
				$user_product['username'] = $request['username'];				
				$user_product->save();
				
				$current_user_statistic = new CurrentUserStatistic($product->toArray());
				$current_user_statistic['username'] = $request['username'];				
				$current_user_statistic->save();
				
				
				return response()->json(CreateData::create_data(['user_product' => $user_product]));
			}
			
			catch(ModelNotFoundException $e){
				return CreateError::create_error(['Podany użytkownik nie istnieje']);
			}
		}
	}
}
