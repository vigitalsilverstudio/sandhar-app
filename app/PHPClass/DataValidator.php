<?php

namespace App\PHPClass;

use Validator;
use Request;

class DataValidator{
	
	protected static function validate_data($input, $input_key, $rules, $messages){
		
		$request = new Request([$input_key => $input]);
		$validator = Validator::make($request::all(), $rules, $messages);
		
		if($validator->fails()){
			return $validator->errors();
		}
	}
}