<?php

namespace App\PHPClass;

class CreateError{
	
	public static function create_error($errors){
		
		$data_array = [
			'success' => false,
			'data' => null,			
		];
		
		foreach($errors as $key => $value){
			$data_array['errors'][$key] = $value;
		}
		
		return $data_array;
	}
}