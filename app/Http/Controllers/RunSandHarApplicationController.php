<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;

class RunSandHarApplicationController extends Controller{
    
	public function run_sandhar_application(){
		return File::get(public_path() . '/templates/index.html');
	}
}
