<?php

namespace App\PHPClass;

use App\PHPClass\DataValidator;

class MinProductionLevelValidator extends DataValidator{
	
	public static function validate($input){
		
		$input_key = 'min_production_level';
		$rules = [$input_key => 'required|integer'];
		
		$messages = [
			$input_key . '.required' => 'Pole norma godzinowa nie może być puste',
			$input_key . '.integer' => 'Pole norma godzinowa może zawierać cyfry',
		];
		
		
		return parent::validate_data($input, $input_key, $rules, $messages);
	}
}