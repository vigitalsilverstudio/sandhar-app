<?php

namespace App\PHPClass;

use Excel;
use Carbon\Carbon;

class SaveAsToExcel{
    
    public static function save_as_to_excel($filename, $sheetname, $model, $model_header){        
        Excel::create($filename, function($excel) use($model, $model_header, $sheetname){
            $excel->sheet($sheetname, function($sheet) use($model, $model_header){
                $sheet->row(1,['Data archiwizacji:', Carbon::now()->toDateString()]);
				$sheet->row(2,$model_header);                
                $sheet->fromModel($model,null,'A2',true,false);                                   
            });
        })->download('xlsx');
    }
}