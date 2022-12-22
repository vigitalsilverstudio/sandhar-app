<?php

namespace App\PHPClass;

use App\PHPClass\DataValidator;

class ProductNameValidator extends DataValidator{
	
	public static function validate($input){
		
		$input_key = 'product_name';
		$rules = [$input_key => 'required|string'];
		
		$messages = [
			$input_key . '.required' => 'Pole nazwa produktu nie może być puste',
			$input_key . '.string' => 'Pole nazwa produktu jest nie poprawne nie dozwolone znaki',
		];
		
		
		return parent::validate_data($input, $input_key, $rules, $messages);
	}
}