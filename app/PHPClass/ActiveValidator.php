<?php

namespace App\PHPClass;

use App\PHPClass\DataValidator;

class ActiveValidator extends DataValidator{
	
	public static function validate($input){
		
		$input_key = 'active';
		$rules = [$input_key => 'required|boolean'];
		
		$messages = [
			$input_key . '.required' => 'Pole stan konta nie może być puste',
			$input_key . '.alpha' => 'Pole stan konta może zawierać tylko wartość logiczną',
		];
		
		
		return parent::validate_data($input, $input_key, $rules, $messages);
	}
}