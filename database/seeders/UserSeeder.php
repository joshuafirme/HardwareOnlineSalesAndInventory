<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
            'name' => 'Kenneth',
            'username' => 'kenneth',
            'email' => 'test@gmail.com',
            'password' => \Hash::make('12345'),
            'access_level' => 4,
            'status' => 1
        ]);
    }
}
