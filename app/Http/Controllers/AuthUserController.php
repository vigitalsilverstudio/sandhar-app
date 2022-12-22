<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Firebase\JWT\JWT;

use App\PHPClass\CreateData;
use App\PHPClass\CreateError;

class AuthUserController extends Controller
{
    public function auth_user(Request $request){
		
		$token = $request->header('Authorization');
		
		$token = str_replace('Bearer ', '', $token);
		
		try{
			$user = (array) JWT::decode($token, env('APP_KEY'),['HS256']);
		}
		
		catch(\UnexpectedValueException $e){
			return response()->json(CreateError::create_error(['Nie znaleziono tokena użytkownika']));
		}
		
		catch(\Exception $e){
			return response()->json(CreateError::create_error(['Nie poprawny token użytkownika']));
		}
		
		
		return response()->json(CreateData::create_data(['user' => $user]));
	}
}
