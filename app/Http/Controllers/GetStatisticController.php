<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\PHPClass\CreateData;
use App\PHPClass\CreateError;

use App\Statistic;

class GetStatisticController extends Controller{
    
	public function get_statistic($product_id, $id){
		try{
			$statistic = Statistic::where('product_id',$product_id)->where('id', $id)->firstOrFail();
			return response()->json(CreateData::create_data(['statistic' => $statistic]));
		}
		
		catch(ModelNotFoundException $e){
			return response()->json(CreateError::create_error(['Podana statystyka nie istnieje']));
		}
	}
}
