<?php

namespace App\PHPClass;
use Auth;

class FindUser{

	public static function find_user($find_user_dict){
		
		Auth::attempt($find_user_dict);
		$user = Auth::user();
		
		Auth::logout();
		return $user ?? null;
	}
}