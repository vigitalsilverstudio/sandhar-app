<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\User;

use App\PHPClass\Sanitizer;
use App\PHPClass\MyValidator;

use App\PHPClass\CreateError;
use App\PHPClass\CreateData;
use App\PHPClass\CreateValidationErrors;

class EditUserController extends Controller{
    
	public function edit_user($username, Request $request){
		
		foreach($request->all() as $key => $value){
			$request[$key] = Sanitizer::sanitize($value);
		}
		
		$object = [
			['first_name' => 'App\PHPClass\FirstNameValidator::validate'],
			['last_name' => 'App\PHPClass\LastNameValidator::validate'],
			['email' => 'App\PHPClass\EmailValidator::validate'],
			['username' => 'App\PHPClass\UsernameValidator::validate'],
			['password' => 'App\PHPClass\CustomEditPasswordValidator::validate'],
			['active' => 'App\PHPClass\ActiveValidator::validate'],
			['staff' => 'App\PHPClass\StaffValidator::validate'],			
		];
		
		$validation_status = MyValidator::validate($object, $request);
		$validation_status = CreateValidationErrors::create_validation_errors($validation_status);
		
		if($validation_status != []){
			$user_error = CreateError::create_error($validation_status);
			return response()->json($user_error);
		}		

		try{
			$user = User::where('username', $username)->firstOrFail();
			
			if($user->superuser){
				return CreateError::create_error(['user_staff', 'Nie można edytować konta programisty']);
			}
			
			$request['password'] = bcrypt($request['password']);
			$user->update($request->all());
			
			return response()->json(CreateData::create_data(['user' => $user]));
		}
		
		catch(ModelNotFoundException $e){
			CreateError::create_error(['Podany użytkownik nie istnieje']);
		}
	}
}
