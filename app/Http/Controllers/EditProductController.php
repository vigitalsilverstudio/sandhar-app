<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Product;

use App\PHPClass\Sanitizer;
use App\PHPClass\MyValidator;

use App\PHPClass\CreateError;
use App\PHPClass\CreateData;
use App\PHPClass\CreateValidationErrors;

class EditProductController extends Controller{
    
	
	public function edit_product($product_id, Request $request){
		
		foreach($request->all() as $key => $value){
			$request[$key] = Sanitizer::sanitize($value);
		}
		
		$object = [
			['product_id' => 'App\PHPClass\ProductIDValidator::validate'],
			['product_name' => 'App\PHPClass\ProductNameValidator::validate'],
			['company_name' => 'App\PHPClass\CompanyNameValidator::validate'],
			['min_production_level' => 'App\PHPClass\MinProductionLevelValidator::validate'],
		];
		
		$validation_status = MyValidator::validate($object, $request);
		$validation_status = CreateValidationErrors::create_validation_errors($validation_status);
		
		
		if($validation_status != []){
			$product_error = CreateError::create_error($validation_status);
			return response()->json($product_error);
		}
		
		try{
			$product = Product::where('product_id', $product_id)->firstOrFail();
			$product->update($request->all());
			
			return response()->json(CreateData::create_data(['product' => $product]));
		}
		
		
		catch(ModelNotFoundException $e){
			return CreateError::create_error(['product_not_found', 'Podany produkt nie istnieje']);;
		}
	}
}
