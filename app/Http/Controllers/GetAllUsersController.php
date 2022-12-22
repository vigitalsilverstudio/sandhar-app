<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PHPClass\CreateData;
use App\User;

class GetAllUsersController extends Controller{
    
  public function get_all_users(Request $request){
    
    if(isset($request->query()['page']) == true){
      $users = User::paginate(50);
    }
    
    else{
      $users = User::all();
    }
      
    $users_object = [
      'users' => $users,  
    ];
    
    return response()->json(CreateData::create_data($users_object));      
  }
}
