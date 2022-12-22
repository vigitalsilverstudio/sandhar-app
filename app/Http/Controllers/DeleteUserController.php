<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\User;

use App\PHPClass\CreateError;
use App\PHPClass\CreateData;

class DeleteUserController extends Controller{
    
	public function delete_user($username){
		
		try{
			$user = User::where('username', $username)->firstOrFail();
			
			if($user->superuser){
				return response()->json(CreateError::create_error(['Nie można usunąć konta programisty']));
			}
			
			else{
				$user->delete();
				return response()->json(CreateData::create_data(['user' => $user]));
			}
		}
		
		catch(ModelNotFoundException $e){
			return response()->json(CreateError::create_error(['Podany użytkownik nie istnieje']));
		}
	}
}
