<?php

namespace App\PHPClass;

use App\PHPClass\DataValidator;

class CompanyNameValidator extends DataValidator{
	
	public static function validate($input){
		
		$input_key = 'company_name';
		$rules = [$input_key => 'required|alpha'];
		
		$messages = [
			$input_key . '.required' => 'Pole nazwa firmy nie może być puste',
			$input_key . '.alpha' => 'Pole nazwa firmy może zawierać tylko litery',
		];
		
		
		return parent::validate_data($input, $input_key, $rules, $messages);
	}
}