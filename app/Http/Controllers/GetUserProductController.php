<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\PHPClass\CreateError;
use App\PHPClass\CreateData;

use App\UserProduct;

class GetUserProductController extends Controller{
    
	public function get_user_product($product_id, $login){
		try{
			$user_product = UserProduct::where('product_id', $product_id)->where('username', $login)->firstOrFail();
			return response()->json(CreateData::create_data(['user_product' => $user_product]));
		}
		
		catch(ModelNotFoundException $e){
			return response()->json(CreateError::create_error(['Podany produkt użytkownika nie istnieje']));
		}
	}
}
