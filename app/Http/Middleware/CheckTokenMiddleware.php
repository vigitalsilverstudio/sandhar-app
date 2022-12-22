<?php

namespace App\Http\Middleware;

use Closure;

use App\PHPClass\DecodeToken;
use App\PHPClass\CreateError;

class CheckTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		try{
			$user_object = (array)DecodeToken::decode_token($request);			
		}
		
		catch(\UnexpectedValueException $e){
			return response()->json(CreateError::create_error(['Nie znaleziono tokena użytkownika']));
		}
		
		catch(\Exception $e){
			return response()->json(CreateError::create_error(['Nie poprawny token użytkownika']));
		}
		
		
		if(!($user_object['staff'] or $user_object['superuser'])){
			return response()->json(CreateError::create_error(['Nie można wykonać zapytania nie masz uprawnień']));
		}
		
        return $next($request);
    }
}
