<?php 

namespace App\PHPClass;

class MyValidator{

	public static function validate($object, $request){
	
		$validation_status = [];
		
		for($n = 0; $n < count($object); $n++){
			foreach($object[$n] as $key => $value){
								
				if($request->has($key)){					
					array_push($validation_status,call_user_func($value, $request[$key]));
				}
				
				else{
					$request[$key] = '';
					$n--;
					continue;
				}
			}
		}
		
		return $validation_status;
	}
}