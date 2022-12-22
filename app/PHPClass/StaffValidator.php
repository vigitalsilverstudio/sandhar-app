<?php

namespace App\PHPClass;

use App\PHPClass\DataValidator;

class StaffValidator extends DataValidator{
	
	public static function validate($input){
		
		$input_key = 'staff';
		$rules = [$input_key => 'required|boolean'];
		
		$messages = [
			$input_key . '.required' => 'Pole dostęp do panelu nie może być puste',
			$input_key . '.boolean' => 'Pole dostęp do panelu może zawierać tylko wartośc logiczną',
		];
		
		return parent::validate_data($input, $input_key, $rules, $messages);
	}
}