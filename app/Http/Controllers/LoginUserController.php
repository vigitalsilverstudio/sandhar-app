<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\PHPClass\Sanitizer;

use App\PHPClass\MyValidator;

use App\PHPClass\CreateValidationErrors;
use App\PHPClass\CreateLoginError;
use App\PHPClass\CreateLoginData;

use App\PHPClass\FindUser;
use App\PHPClass\CreateToken;

class LoginUserController extends Controller{
    
	public function login_user(Request $request){
		
		$username = $request['username'];
		$password = $request['password'];
		$staff = $request['staff'];
		
		$username = Sanitizer::sanitize($username);
		$password = Sanitizer::sanitize($password);
		$staff = Sanitizer::sanitize($staff);
		
		$validation_object = [			
			['username' => 'App\PHPClass\UsernameValidator::validate'],
			['password' => 'App\PHPClass\PasswordValidator::validate'],			
			['staff' => 'App\PHPClass\StaffValidator::validate'],			
		];
			
		$validation_status = MyValidator::validate($validation_object, $request);		
		$validation_status = CreateValidationErrors::create_validation_errors($validation_status);
		
		if($validation_status != []){
			$login_error = CreateLoginError::create_login_error($validation_status);
			return response()->json($login_error);
		}
		
		$find_user_dict = [
			'username' => $username,
			'password' => $password
		];
		
		try{
			$user = FindUser::find_user($find_user_dict);
		}
		
		catch(QueryException $e){
			return CreateLoginError::create_login_error(['Nie można nawiązać połączenia z serwerem bazy danych']);
		}
		
		if($user == null){
			return CreateLoginError::create_login_error(['Nie poprawne dane logowania']);
		}
		
		if($staff == '0'){
			if($user->active or $user->superuser){				
			}
			
			else{
				return CreateLoginError::create_login_error(['Twoje konto nie jest aktywne']);
			}
		}
		
		else if($staff == '1'){
			if($user->active or $user->superuser){				
				if($user->staff or $user->superuser){
				}
				
				else{
					return CreateLoginError::create_login_error(['Nie masz uprawnień aby zalogować się tutaj']);
				}
			}
			
			else{
				return CreateLoginError::create_login_error(['Twoje konto jest nie aktywne']);
			}
		}
		
		else{
			return CreateLoginError::create_login_error(['Nie poprawny typ logowania']);
		}
		
		$token_array = [
			'user' => [
				'username' => $user->username,
				'active' => $user->active,
				'staff' => $user->staff,
				'superuser' => $user->superuser,
			]
		];
		
		$token = CreateToken::create_token($token_array);
		$token_data = CreateLoginData::create_login_data($token);
		
		return response()->json($token_data);
	}
}
