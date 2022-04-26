<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($i=0 ; $i < 1000  ; $i++ ) { 
            \App\Models\School::factory(1)->create();
        }
    }
}
