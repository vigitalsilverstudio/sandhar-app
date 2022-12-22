<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            
			$table->string('first_name');
			$table->string('last_name');
			$table->string('email');
			
			$table->string('username');
			$table->string('password');
			
			$table->boolean('active')->default(true);
			$table->boolean('staff')->default(false);
			$table->boolean('superuser')->default(false);
			
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
