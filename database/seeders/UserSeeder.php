<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   

        \DB::table('users')->insert([
            [
                'name' => 'Aina Marie Gayle Gonzales',
                'username' => 'ainamarie',
                'email' => 'test21@gmail.com',
                'password' => \Hash::make('12345'),
                'access_level' => 4,
                'status' => 1
            ],
            [
                'name' => 'Honey Grace Causapin',
                'username' => 'honeygrace',
                'email' => 'test3@gmail.com',
                'password' => \Hash::make('12345'),
                'access_level' => 4,
                'status' => 1
            ],
            [
                'name' => 'Catherine Medina',
                'username' => 'catherine',
                'email' => 'test4@gmail.com',
                'password' => \Hash::make('12345'),
                'access_level' => 4,
                'status' => 1
            ]   
        ]);
       
    }
}
