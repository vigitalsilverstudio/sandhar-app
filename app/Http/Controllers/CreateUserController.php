<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;

use App\PHPClass\Sanitizer;
use App\PHPClass\MyValidator;

use App\PHPClass\CreateData;
use App\PHPClass\CreateError;

use App\PHPClass\CreateValidationErrors;

class CreateUserController extends Controller{
    
  public function create_user(Request $request){
        
    foreach($request->all() as $key => $value){
      $request[$key] = Sanitizer::sanitize($value);
    }
    
    $object = [
      ['first_name' => 'App\PHPClass\FirstNameValidator::validate'],
      ['last_name' => 'App\PHPClass\LastNameValidator::validate'],
      ['email' => 'App\PHPClass\EmailValidator::validate'],
      ['username' => 'App\PHPClass\UsernameValidator::validate'],
      ['password' => 'App\PHPClass\CustomCreatePasswordValidator::validate'],
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
      $user = User::where('username', $request['username'])->firstOrFail();
      return CreateError::create_error(['user_found', 'Taki użytkownik o podanym loginie użytkownika już istnieje']);
    }
    
    catch(ModelNotFoundException $e){
      $request['password'] = bcrypt($request['password']);
      $user = User::create($request->all());
      return response()->json(CreateData::create_data(['user' => $user]));
    }
  }
}
