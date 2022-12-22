<?php

namespace App\PHPClass;

class CreateLoginError{
	
	public static function create_login_error($errors){
		
		$errors_array = [
			'success' => false,
			'errors' => [],
			'data' => null
		];
		
		foreach($errors as $error){
			array_push($errors_array['errors'], $error);
		}
		
		return $errors_array;
	}
}