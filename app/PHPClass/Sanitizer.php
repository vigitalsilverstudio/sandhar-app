<?php

namespace App\PHPClass;

class Sanitizer{	
	
	public static function sanitize($input){
		
		$input = strip_tags($input);
		$input = trim($input);
		
		return $input;
	}
}