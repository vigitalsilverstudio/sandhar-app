<?php

namespace App\PHPClass;

class CreateLoginData{
	
	public static function create_login_data($token){
		
		$data_array = [
			'success' => true,
			'errors' => null,
			'data' => [
				'token' => $token
			]
		];
		
		return $data_array;
	}
}