<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\PHPClass\SaveAsToExcel;

class SaveAllProductsController extends Controller{
    
	public function save_all_products(){
		$only = [
			'id',
			'product_name',
			'product_id',
			'company_name',
			'min_production_level',
			'attentions',
			'created_at',
			'updated_at'
		];
		
		$products = Product::all($only);
		
        $products_header = [
            'ID',
            'Nazwa produktu',
            'ID produktu',
            'Nazwa firmy',            
            'Norma godzinowa',
			'Uwagi do produktu',
            'Data utworzenia',
            'Data modyfikacji',
        ];
        
        $response = SaveAsToExcel::save_as_to_excel('Produkty', 'Produkty', $products, $products_header);
	}
}
