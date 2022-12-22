<?php

namespace App\PHPClass;

use App\PHPClass\DataValidator;

class UsernameValidator extends DataValidator{
	
	public static function validate($input){
		
		$input_key = 'username';
		$rules = [$input_key => 'required|alpha_num'];
		
		$messages = [
			$input_key . '.required' => 'Pole login użytkownika nie może być puste',
			$input_key . '.alpha_num' => 'Pole login użytkownika może zawierać tylko litery oraz cyfry',
		];
		
		
		return parent::validate_data($input, $input_key, $rules, $messages);
	}
}