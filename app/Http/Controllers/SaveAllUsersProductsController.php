<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\UserProduct;
use App\PHPClass\SaveAsToExcel;

class SaveAllUsersProductsController extends Controller{
    
	public function save_all_users_products(){
		$only = [
			'id',
			'product_name',
			'product_id',
			'company_name',
			'min_production_level',
			'attentions',
			'username',
			'created_at',
			'updated_at'
		];
		
		$products = UserProduct::all($only);
		
        $products_header = [
            'ID',
            'Nazwa produktu',
            'ID produktu',
            'Nazwa firmy',            
            'Norma godzinowa',
			'Uwagi do produktu',
			'Login użytkownika',
            'Data utworzenia',
            'Data modyfikacji',
        ];
        
        $response = SaveAsToExcel::save_as_to_excel('Produkty użytkownika', 'Produkty użytkownika', $products, $products_header);
	}
}
