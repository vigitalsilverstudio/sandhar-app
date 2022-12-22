<?php

namespace App\PHPClass;

use App\CurrentStatistic;
use App\CurrentUserStatistic;
use App\Product;

class CreateAllCurrentStatistics{
  
  public static function create_all_current_statistics(){
    CurrentStatistic::getQuery()->delete();
    $products = Product::all();
        
    for($n = 0; $n < count($products); $n++){
      $current_statistics = new CurrentStatistic($products[$n]->toArray());
      $current_statistics['id'] = $n+1;
      $current_statistics->save();
    }
    
    $current_statistics = CurrentStatistic::all();
    
    $product_status = false;
    
    for($n = 0; $n < count($current_statistics); $n++){
      
      $product = $current_statistics[$n];
      $user_product = CurrentUserStatistic::where('product_id',$product->product_id)->get();      
      
      for($x = 0; $x < count($user_product); $x++){
        foreach($user_product[$x]->toArray() as $key => $value){
          
          if($key == 'username' or $key == 'id') continue;          
          if($key == 'product_id') continue;
          if($key == 'product_name') continue;
          if($key == 'company_name') continue;
          if($key == 'created_at' or $key == 'updated_at') continue;          
          if($key == 'min_production_level') continue;
                    
          if(is_string($value) == true){
            $product[$key] .= $value;
            $product->save();
            continue;
          }
          
          else{
            $product[$key] += $value;
            $product->save();
            continue;
          }                            
        }
      }
    }      
  }
}