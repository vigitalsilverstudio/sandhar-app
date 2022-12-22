<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PHPClass\SaveAsToExcel;
use App\UserStatistic;

class SaveAllUserStatisticsController extends Controller{
    
	public function save_all_user_statistics_autoliv(){
		
		$autoliv_only = [
			'id',
			'product_name',
			'product_id',
			'company_name',
			'min_production_level',
			'attentions',
			'username',
			'number_of_good_products',
			'number_of_bad_products',		
			'number_of_sawn_products',
			'number_of_box',
			'arithmetic_mean',
			'sum_of_products',
				
			'autoliv_defect_1',
			'autoliv_defect_2',
			'autoliv_defect_3',
			'autoliv_defect_4',
			'autoliv_defect_5',
			'autoliv_defect_6',
			'autoliv_defect_7',
			'autoliv_defect_8',
			'autoliv_defect_9',
			'autoliv_defect_10',
			'autoliv_defect_11',
			'autoliv_defect_12',
			'autoliv_defect_13',
			'autoliv_defect_14',
			'autoliv_defect_15',
			
			'created_at',
			'updated_at',
		];
		
		$autoliv_user_statistics = UserStatistic::where('company_name', 'autoliv')->get($autoliv_only);
		
        $autoliv_user_statistics_header = [
            'ID',
            'Nazwa produktu',
            'ID produktu',
            'Nazwa firmy',            
            'Norma godzinowa',
			'Uwagi do produktu',
			'Login użytkownika',			
			'Dobrych produktów',
			'Złych produktów',
			'Piłowanych produktów',
			'Liczba pudełek',
			'Średnia liczba produktów',
			'Suma produktów',
			'Ostra krawędź',
			'Deformacja korpusu szpuli',
			'Ubytek materiału na korpusie szpuli',
			'Złamany ząb',
			'Zły wymiar',
			'Pęknięcie na korpusie szpuli',
			'Korozja (biały nalot)',
			'Deformacja pinu',
			'Brak pinu',
			'Pory',
			'Brud na formie ( olej, smar)',
			'Inna referencja',
			'Inne',
			'Pęknięcia/Ubytki materiału na pinie',
			'Protokół czerwonej szkrzyńki',
			'Data utworzenia',
			'Data modyfikacji',        
        ];
        
        $response = SaveAsToExcel::save_as_to_excel('Statystyki użytkownika Autoliv', 'Statystyki użytkownika autoliv', $autoliv_user_statistics, $autoliv_user_statistics_header);		
	}
	
	public function save_all_user_statistics_trw(){
		$trw_only = [
			'id',
			'product_name',
			'product_id',
			'company_name',
			'min_production_level',
			'attentions',
			'username',
			'number_of_good_products',
			'number_of_bad_products',		
			'number_of_sawn_products',
			'number_of_box',			
			'arithmetic_mean',
			'sum_of_products',
				
			'trw_defect_1',
			'trw_defect_2',
			'trw_defect_3',
			'trw_defect_4',
			'trw_defect_5',
			'trw_defect_6',
			'trw_defect_7',
			'trw_defect_8',
			'trw_defect_9',
			'trw_defect_10',
			'trw_defect_11',
			'trw_defect_12',
			'trw_defect_13',
			'trw_defect_14',
			'trw_defect_15',
			'trw_defect_16',
			'trw_defect_17',
			'trw_defect_18',
			'trw_defect_19',
			'trw_defect_20',
			'trw_defect_21',
			'trw_defect_22',
			'trw_defect_23',
			
			'created_at',
			'updated_at',
		];
		
		$trw_user_statistics = UserStatistic::where('company_name', 'trw')->get($trw_only);
		
        $trw_user_statistics_header = [
            'ID',
            'Nazwa produktu',
            'ID produktu',
            'Nazwa firmy',            
            'Norma godzinowa',
			'Uwagi do produktu',
			'Login użytkownika',			
			'Dobrych produktów',
			'Złych produktów',
			'Piłowanych produktów',
			'Liczba pudełek',
			'Średnia liczba produktów',
			'Suma produktów',
			'Odkształcony kołnierz',
			'Ostra krawędź',
			'Deformacja korpusu szpuli',
			'Ubytek materiału na korpusie',
			'Ubytek materiału na kołnierzu',
			'Brak zębów wokół pinu',
			'Zły wymiar',
			'Pęknięcie na korpusie szpuli',
			'Korozja (biały nalot)',
			'Deformacja pinu',
			'Brak pinu',
			'Pory',
			'Brud na formie(olej, smar)',
			'Inna referencja',
			'Inne',
			'Uderzenie na kołnierzu',
			'Nadlewy na kołnierzu',
			'Deformacja zaczepu',
			'Ubytek materiału na elipsie',
			'Deformacja zaczepu',
			'Ubytek materiału na zaczepie',
			'Pęknięcia/Ubytki materiału na pinie',
			'Protokół czerwonej skrzynki',
			'Data utworzenia',
			'Data modyfikacji',        
        ];
        
        $response = SaveAsToExcel::save_as_to_excel('Statystyki użytkownika Trw', 'Statystyki użytkownika trw', $trw_user_statistics, $trw_user_statistics_header);
	}
}
