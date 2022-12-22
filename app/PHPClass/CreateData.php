<?php

namespace App\PHPClass;

class CreateData{
	
	public static function create_data($data){
		
		$data_array = [
			'success' => true,
			'errors' => null,			
		];
		
		foreach($data as $key => $value){
			$data_array['data'][$key] = $value;
		}
		
		return $data_array;
	}
}