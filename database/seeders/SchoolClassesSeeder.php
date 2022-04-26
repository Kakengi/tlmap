<?php

namespace Database\Seeders;

use App\Models\SchoolType;
use App\Models\SchoolClass;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class SchoolClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = [
                "Darasa la I",
                "Darasa la II",
                "Darasa la III",
                "Darasa la IV",
                "Darasa la V",
                "Darasa la VI",
                "Darasa la VII",
                "Kidato cha I",
                "Kidato cha II",
                "Kidato cha III",
                "Kidato cha IV",
                "Kidato cha V",
                "Kidato cha VI",
        ];
        foreach($classes as $class){
            SchoolClass::create([
                'name' => $class,
                'school_type_id' => Str::contains($class, 'Darasa') ? 1 : 2,
            ]);
        }
    }
}
