<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Ward;
use App\Models\School;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\SchoolRequirement;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class SchoolRequirementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $randomSchool = School::all();

        $subjectId = Subject::all();
        $ward = Ward::all();

        for ($i = 0; $i < 8; $i++) {
            $datas = [];
            for ($j = 0; $j < 2500; $j++) {
                $num_students = random_int(100, 200);
                $schoolClassId = SchoolClass::where('school_type_id', $randomSchool->random()->school_type_id)
                    ->get();
                $school_class_id = $schoolClassId->random()->id;
                $subject_id = $subjectId->random()->id;
                $book = Book::where('school_class_id', $school_class_id)->where('subject_id', $subject_id)->first();
                $region = optional(optional($ward->random()->district)->region);
                $district = optional($ward->random()->district);
                $datas[] =  [
                    "school_id" => $randomSchool->random()->id,
                    'school_class_id' => $school_class_id,
                    "subject_id" => $subject_id,
                    "school_type_id" => Str::contains($randomSchool->random()->name, 'Primary') ? 1 : 2,
                    "region_id" => $region->id,
                    "district_id" => $district->id,
                    "ward_id" => $ward->random()->id,
                    "region_name" => $region->name,
                    "district_name" => $district->name,
                    "ward_name" => $ward->random()->name,
                    'year_of_study' => 2021,
                    'num_students' => $num_students,
                    'required_books' => ceil($num_students * ($book ? (1 / $book->num_students_per_book) : 1)),
                    'created_at' => \Carbon\carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ];
            }
            SchoolRequirement::insert($datas);
        }
    }
}
