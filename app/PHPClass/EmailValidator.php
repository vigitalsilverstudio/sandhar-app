<?php

namespace App\PHPClass;

use App\PHPClass\DataValidator;

class EmailValidator extends DataValidator{
	
	public static function validate($input){
		
		$input_key = 'email';
		$rules = [$input_key => 'required|email'];
		
		$messages = [
			$input_key . '.required' => 'Pole adres email użytkownika nie może być puste',
			$input_key . '.email' => 'Pole adres email użytkownika jest nie poprawne',
		];
		
		
		return parent::validate_data($input, $input_key, $rules, $messages);
	}
}