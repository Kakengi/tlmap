<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;


class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => "Moris",
            'second_name' => "V",
            'last_name' => "Kakengi",
            'email' => 'moriskakengi@gmail.com',
            'phone_number'=>'0782574894',
            'password' => Hash::make('password'), 
        ]);
    }
}
