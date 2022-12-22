<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStatistic extends Model
{
    protected $fillable = [
		'product_name',
		'product_id',
		'company_name',
		'attentions',
		'number_of_good_products',
		'number_of_bad_products',		
		'number_of_sawn_products',
		'sum_of_products',
		'arithmetic_mean',
		'number_of_box',
		'min_production_level',
		'username',
				
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
		
		'above_min_production_level'
	];
}
