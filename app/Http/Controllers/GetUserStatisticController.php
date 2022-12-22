<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\PHPClass\CreateData;
use App\PHPClass\CreateError;

use App\UserStatistic;

class GetUserStatisticController extends Controller{
    
	public function get_user_statistic($product_id, $login, $id){
		try{
			$user_statistic = UserStatistic::where('product_id',$product_id)->where('username', $login)->where('id', $id)->firstOrFail();
			return response()->json(CreateData::create_data(['user_statistic' => $user_statistic]));
		}
		
		catch(ModelNotFoundException $e){
			return response()->json(CreateError::create_error(['Podana statystyka użytkownika nie istnieje']));
		}
	}
}
