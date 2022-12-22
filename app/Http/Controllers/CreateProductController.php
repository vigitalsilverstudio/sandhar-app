<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Product;
use App\Statistic;
use App\CurrentStatistic;

use App\PHPClass\Sanitizer;
use App\PHPClass\MyValidator;

use App\PHPClass\CreateError;
use App\PHPClass\CreateData;
use App\PHPClass\CreateValidationErrors;

class CreateProductController extends Controller{
    
	public function create_product(Request $request){
			
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
			$product = Product::where('product_id', $request['product_id'])->firstOrFail();
						
			return response()->json(CreateError::create_error(['product_found','Taki produkt o podanym ID produktu już istnieje']));
		}
		
		
		catch(ModelNotFoundException $e){
			
			$request['attentions'] = '';
			
			$product = Product::create($request->all());			
			$current_statistic = CurrentStatistic::create($request->all());
			
			return response()->json(CreateData::create_data(['product' => $product]));
		}
	
	}
}
