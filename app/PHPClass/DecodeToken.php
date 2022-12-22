<?php 

namespace App\PHPClass;

use Firebase\JWT\JWT;

class DecodeToken{

	public static function decode_token($request){
		
		$token = $request->header('Authorization');
		$token = str_replace('Bearer ', '', $token);
		
		$user = (array) JWT::decode($token, env('APP_KEY'),['HS256']);
		
		return $user;
	}
}