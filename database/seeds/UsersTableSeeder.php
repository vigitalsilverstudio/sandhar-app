<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder{
  
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        
    User::create([
      'first_name' => 'Kamil',
      'last_name' => 'Nocuń',
      'email' => 'programista@sandhar.pl',
      'username' => 'Programista',
      'password' => bcrypt('Programista'),
      'staff' => true,
      'superuser' => true,
    ]);
    }
}
