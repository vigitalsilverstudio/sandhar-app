<?php

namespace App\PHPClass;

class CreateValidationErrors{

	public static function create_validation_errors($validation_array){
		
		$validation_errors = [];
		
		foreach($validation_array as $index){
			
			$validation_object = $index;
			
			if($validation_object == null){
				continue;
			}
			
			$validation_object_key = $validation_object->keys()[0];
			
			foreach($validation_object->get($validation_object_key) as $value){
				array_push($validation_errors, $value);
			}
		}
		
		return $validation_errors;
	}
}