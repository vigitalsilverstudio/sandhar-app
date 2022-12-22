<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', 'LoginUserController@login_user');
Route::post('/auth', 'AuthUserController@auth_user');

Route::middleware(['\App\Http\Middleware\CheckTokenMiddleware'])->group(function(){
	Route::get('/users', 'GetAllUsersController@get_all_users');
	Route::get('/users/{username}', 'GetUserController@get_user');
	Route::post('/users', 'CreateUserController@create_user');
	Route::post('/users/save', 'SaveAllUsersController@save_all_users');
	Route::delete('/users/{username}', 'DeleteUserController@delete_user');
	Route::put('/users/{username}', 'EditUserController@edit_user');


	Route::get('/products', 'GetAllProductsController@get_all_products');
	Route::get('/products/{product_id}', 'GetProductController@get_product');
	Route::post('/products', 'CreateProductController@create_product');
	Route::post('/products/save', 'SaveAllProductsController@save_all_products');
	Route::delete('/products/{product_id}', 'DeleteProductController@delete_product');
	Route::put('/products/{product_id}', 'EditProductController@edit_product');


	Route::get('/users_products', 'GetAllUsersProductsController@get_all_users_products');
	Route::get('/users_products/{product_id}/{login}', 'GetUserProductController@get_user_product');
	Route::post('/users_products', 'CreateUserProductController@create_user_product');
	Route::post('/users_products/save', 'SaveAllUsersProductsController@save_all_users_products');
	Route::delete('/users_products/{product_id}/{login}', 'DeleteUserProductController@delete_user_product');

	Route::get('/statistics', 'GetAllStatisticsController@get_all_statistics');
	Route::get('/statistics/create', 'CreateAllStatisticsController@create_all_statistics');
	Route::get('/statistics/{product_id}/{id}', 'GetStatisticController@get_statistic');
	Route::post('/statistics/save/autoliv', 'SaveAllStatisticsController@save_all_statistics_autoliv');
	Route::post('/statistics/save/trw', 'SaveAllStatisticsController@save_all_statistics_trw');

	Route::get('/user_statistics', 'GetAllUserStatisticsController@get_all_user_statistics');
	Route::get('/user_statistics/create', 'CreateAllUserStatisticsController@create_all_user_statistics');
	Route::get('/user_statistics/{product_id}/{login}/{id}', 'GetUserStatisticController@get_user_statistic');
	Route::post('/user_statistics/save/autoliv', 'SaveAllUserStatisticsController@save_all_user_statistics_autoliv');
	Route::post('/user_statistics/save/trw', 'SaveAllUserStatisticsController@save_all_user_statistics_trw');
	
	Route::get('/new_hour', 'UpdateCurrentUserStatisticController@new_hour');
});


Route::middleware(['\App\Http\Middleware\CheckWorkerTokenMiddleware'])->group(function(){
	
	Route::get('/current_statistics', 'GetAllCurrentStatisticsController@get_all_current_statistics');
	Route::get('/current_statistics/{product_id}', 'GetCurrentStatisticController@get_current_statistic');
	
	Route::get('/current_user_statistics', 'GetAllCurrentUserStatisticsController@get_all_current_user_statistics');
	Route::get('/current_user_statistics/{product_id}', 'GetCurrentUserStatisticProductListController@get_current_user_statistic_product_list');
	Route::get('/current_user_statistics/{product_id}/{login}', 'GetCurrentUserStatisticController@get_current_user_statistic');
	Route::put('/current_user_statistics/{product_id}/{login}', 'UpdateCurrentUserStatisticController@update_current_user_statistic');
	
});