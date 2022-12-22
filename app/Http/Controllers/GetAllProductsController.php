<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PHPClass\CreateData;
use App\Product;

class GetAllProductsController extends Controller{    

  public function get_all_products(Request $request){
    
    if(isset($request->query()['page']) == true){
      $products = Product::paginate(50);
    }
    
    else{
      $products = Product::all();
    }
    
    
      
    $products_object = [
      'products' => $products,  
    ];
    
    return response()->json(CreateData::create_data($products_object));

  }
}
