<?php

namespace App\PHPClass;

use App\PHPClass\DataValidator;

class CustomCreatePasswordValidator extends DataValidator{
	
	public static function validate($input)
	{
		$input_key = 'password';
		$rules = [$input_key => 'required|string|min:6|confirmed'];
		
		$messages = [		
			$input_key . '.required' => 'Pole hasło użytkownika nie może być puste',
			$input_key . '.string' => 'Pole hasło użytkownika jest nie poprawne nie dozwolone znaki',
			$input_key . '.min' => 'Pole hasło użytkownika jest za krótkie minimum 6 znaków',
			$input_key . '.confirmed' => 'Pole hasło użytkownika jest nie poprawne dwa różne hasła',
		];
		
		return parent::validate_data($input, $input_key, $rules, $messages);
	}
}