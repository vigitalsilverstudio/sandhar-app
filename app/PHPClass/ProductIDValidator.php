<?php

namespace App\PHPClass;

use App\PHPClass\DataValidator;

class ProductIDValidator extends DataValidator{
	
	public static function validate($input){
		
		$input_key = 'product_id';
		$rules = [$input_key => 'required|alpha_num'];
		
		$messages = [
			$input_key . '.required' => 'Pole ID produktu nie może być puste',
			$input_key . '.alpha_num' => 'Pole ID produktu może zawierać tylko litery oraz cyfry',
		];
		
		
		return parent::validate_data($input, $input_key, $rules, $messages);
	}
}