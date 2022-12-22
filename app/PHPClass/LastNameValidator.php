<?php

namespace App\PHPClass;

use App\PHPClass\DataValidator;

class LastNameValidator extends DataValidator{
	
	public static function validate($input){
		
		$input_key = 'last_name';
		$rules = [$input_key => 'required|alpha'];
		
		$messages = [
			$input_key . '.required' => 'Pole nazwisko użytkownika nie może być puste',
			$input_key . '.alpha' => 'Pole nazwisko użytkownika może zawierać tylko litery',
		];
		
		
		return parent::validate_data($input, $input_key, $rules, $messages);
	}
}