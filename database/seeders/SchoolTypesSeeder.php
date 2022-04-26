<?php

namespace Database\Seeders;

use App\Models\SchoolType;
use Illuminate\Database\Seeder;

class SchoolTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $types = [
                "Primary",
                "Secondary",
        ];
        foreach($types as $type){
            SchoolType::create([
                'name' => $type,
            ]);
        }
    }
}
