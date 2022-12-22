<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PHPClass\CreateData;
use App\UserProduct;

class GetAllUsersProductsController extends Controller{
    
  public function get_all_users_products(Request $request){
    
    if(isset($request->query()['page']) == true){
      $users_products = UserProduct::paginate(50);
    }
    
    else{
      $users_products = UserProduct::all();
    }
          
    $users_products_object = [
      'users_products' => $users_products,  
    ];
    
    return response()->json(CreateData::create_data($users_products_object));
    
  }
}
