<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\CurrentUserStatistic;

class GetCurrentUserProduct extends Controller
{
    public function get_current_user_product($product_id, $login){
		try{
			$user_product = CurrentUserStatistic::where('product_id', $product_id)->where('username', $login)->firstOrFail();
			return response()->json(CreateData::create_data(['current_user_product' => $user_product]));
		}
		
		catch(ModelNotFoundException $e){
			return CreateError::create_error(['Podany produkt użytkownika nie istnieje']);
		}
	}
}
