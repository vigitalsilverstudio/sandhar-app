<?php

namespace App\PHPClass;

use Firebase\JWT\JWT;

class CreateToken{
	
	public static function create_token($token_array){
		
		$token_array_object = [
			'iss' => 'http://kamilnocun1995.usermd.net',
			'aud' => 'http://kamilnocun1995.usermd.net',
			'jti' => uniqid('SandHar',true),
			'iat' => time(),
			'nbf' => time(),
			'exp' => time()+3600,
			
		];
		
		foreach($token_array as $key => $value){
			foreach($value as $key1 => $value1){
				$token_array_object[$key1] = $value1;
			}
		}
	
		$token = JWT::encode($token_array_object, env('APP_KEY'), 'HS256');
		
		return (string) $token;
	}
}