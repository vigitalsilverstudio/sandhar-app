<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProduct extends Model
{
    protected $fillable = [
		'product_name',
		'product_id',
		'company_name',
		'attentions',		
		'min_production_level',
		'login',
	];
}
