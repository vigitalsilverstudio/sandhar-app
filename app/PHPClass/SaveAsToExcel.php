<?php

namespace App\PHPClass;

use Excel;
use Carbon\Carbon;

class SaveAsToExcel{
    
    public static function save_as_to_excel($filename, $sheetname, $model, $model_header){        
        Excel::create($filename, function($excel) use($model, $model_header, $sheetname){
            $excel->sheet($sheetname, function($sheet) use($model, $model_header){

				for($n = 0; $n < count($model); $n++){
					$model[$n]['created_at'] = $model[$n]['created_at']->toDateString();
					$model[$n]['updated_at'] = $model[$n]['updated_at']->toDateString();									
				}
				
				$sheet->row(1,$model_header);                
                $sheet->fromModel($model,null,'A2',true,false);                                   
            });
        })->download('xlsx');
    }
}