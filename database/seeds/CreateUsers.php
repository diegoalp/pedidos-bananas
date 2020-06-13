<?php

use Illuminate\Database\Seeder;
use App\User;

class CreateUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
        	'name' => 'Bananas Café', 
        	'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'user_type' => 'admin'
        ]);

        $user = User::create([
        	'name' => 'Diêgo Pessoa', 
        	'email' => 'funcionario@gmail.com',
            'password' => bcrypt('123456'),
            'user_type' => 'funcionario'
        ]);
    }
}
