<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\PHPClass\SaveAsToExcel;

class SaveAllUsersController extends Controller{
    
	public function save_all_users(){
		$users = User::all();
		
        $users_header = [
            'ID',
            'Imię',
            'Nazwisko',
            'Adres email',            
            'Login',
            'Stan konta',
            'Dostęp do panelu',
            'Konto programisty',
            'Data utworzenia',
            'Data modyfikacji',
        ];
        
        $response = SaveAsToExcel::save_as_to_excel('Uzytkownicy', 'Użytkownicy', $users, $users_header);                
	}
	
}
