<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\User;
use App\PHPClass\CreateData;
use App\PHPClass\CreateError;

use App\PHPClass\DecodeToken;

class GetUserController extends Controller{
	
	public function get_user($username, Request $request){
		
		try{
			$user = User::where(['username' => $username])->firstOrFail();
			return response()->json(CreateData::create_data(['user' => $user]));
		}
		
		catch(ModelNotFoundException $e){
			return response()->json(CreateError::create_error(['Podany użytkownik nie istnieje']));
		}
		
	}
}
