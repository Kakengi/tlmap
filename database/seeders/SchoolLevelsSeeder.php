<?php

namespace Database\Seeders;

use App\Models\SchoolLevel;
use App\Models\SchoolType;
use Illuminate\Database\Seeder;

class SchoolLevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $levels = [
            "Darasa I - VII",
            "Kidato I - IV",
            "Kidato I - VI",
            "Kidato V - VI"
        ];
        foreach ($levels as $level) {
            SchoolLevel::create([
                'name' => $level,
                'school_type_id' => str_contains($level, 'Darasa') ? 1 : 2
            ]);
        }
    }
}
