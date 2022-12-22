<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\PHPClass\CreateError;
use App\PHPClass\CreateData;

use App\Product;

class GetProductController extends Controller{
    
	public function get_product($product_id){
	
		try{
			$product = Product::where('product_id', $product_id)->firstOrFail();
			return response()->json(CreateData::create_data(['product' => $product]));
		}
		
		catch(ModelNotFoundException $e){
			return response()->json(CreateError::create_error(['Podany produkt nie istnieje']));
		}
	}
}
