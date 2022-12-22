<?php

namespace App\PHPClass;

use App\PHPClass\DataValidator;

class FirstNameValidator extends DataValidator{
	
	public static function validate($input){
		
		$input_key = 'first_name';
		$rules = [$input_key => 'required|alpha'];
		
		$messages = [
			$input_key . '.required' => 'Pole imię użytkownika nie może być puste',
			$input_key . '.alpha' => 'Pole imię użytkownika może zawierać tylko litery',
		];
		
		
		return parent::validate_data($input, $input_key, $rules, $messages);
	}
}