<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $subjects = [
            "Kiswahili",
            "Hisabati",
            "Sayansi",
            "English"
        ];
        foreach ($subjects as $name) {
            Subject::create([
                'name' => $name
            ]);
        }
    }
}
