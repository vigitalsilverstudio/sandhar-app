<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_statistics', function (Blueprint $table) {
            $table->increments('id');
			
			$table->string('product_name');
			$table->string('product_id');
			$table->string('company_name');
			$table->string('attentions');
			$table->integer('min_production_level');
			$table->string('username');			
			
			$table->integer('number_of_good_products')->default(0);
			$table->integer('number_of_bad_products')->default(0);
			$table->integer('number_of_sawn_products')->default(0);
			$table->integer('number_of_box')->default(0);
			$table->double('arithmetic_mean')->default(0);
			$table->integer('sum_of_products')->default(0);
			
			$table->integer('autoliv_defect_1')->default(0);
			$table->integer('autoliv_defect_2')->default(0);
			$table->integer('autoliv_defect_3')->default(0);
			$table->integer('autoliv_defect_4')->default(0);
			$table->integer('autoliv_defect_5')->default(0);
			$table->integer('autoliv_defect_6')->default(0);
			$table->integer('autoliv_defect_7')->default(0);
			$table->integer('autoliv_defect_8')->default(0);
			$table->integer('autoliv_defect_9')->default(0);
			$table->integer('autoliv_defect_10')->default(0);
			$table->integer('autoliv_defect_11')->default(0);
			$table->integer('autoliv_defect_12')->default(0);
			$table->integer('autoliv_defect_13')->default(0);
			$table->integer('autoliv_defect_14')->default(0);
			$table->integer('autoliv_defect_15')->default(0);
			
			$table->integer('trw_defect_1')->default(0);
			$table->integer('trw_defect_2')->default(0);
			$table->integer('trw_defect_3')->default(0);
			$table->integer('trw_defect_4')->default(0);
			$table->integer('trw_defect_5')->default(0);
			$table->integer('trw_defect_6')->default(0);
			$table->integer('trw_defect_7')->default(0);
			$table->integer('trw_defect_8')->default(0);
			$table->integer('trw_defect_9')->default(0);
			$table->integer('trw_defect_10')->default(0);
			$table->integer('trw_defect_11')->default(0);
			$table->integer('trw_defect_12')->default(0);
			$table->integer('trw_defect_13')->default(0);
			$table->integer('trw_defect_14')->default(0);
			$table->integer('trw_defect_15')->default(0);
			$table->integer('trw_defect_16')->default(0);
			$table->integer('trw_defect_17')->default(0);
			$table->integer('trw_defect_18')->default(0);
			$table->integer('trw_defect_19')->default(0);
			$table->integer('trw_defect_20')->default(0);
			$table->integer('trw_defect_21')->default(0);
			$table->integer('trw_defect_22')->default(0);
			$table->integer('trw_defect_23')->default(0);
			
			$table->string('above_min_production_level')->default('');
			
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_statistics');
    }
}
