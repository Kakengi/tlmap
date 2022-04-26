<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\School;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\Ward;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SchoolRequirementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $num_students = random_int(100, 200);
        $randomSchool = School::all()->random();
        $schoolClassId = SchoolClass::where('school_type_id', $randomSchool->school_type_id)
            ->get()
            ->random()
            ->id;
        $subjectId = Subject::all()->random()->id;
        $book = Book::where('school_class_id', $schoolClassId)->where('subject_id', $subjectId)->first();
        $ward = Ward::all()->random();
        $region = optional(optional($ward->district)->region);
        $district = optional($ward->district);
        return [
            "school_id" => $randomSchool->id,
            'school_class_id' => $schoolClassId,
            "subject_id" => $subjectId,
            "school_type_id" => Str::contains($randomSchool->name, 'Primary') ? 1 : 2,
            "region_id" => $region->id,
            "district_id" => $district->id,
            "ward_id" => $ward->id,
            "region_name" => $region->name,
            "district_name" => $district->name,
            "ward_name" => $ward->name,
            'year_of_study' => 2021,
            'num_students' => $num_students,
            'required_books' => ceil($num_students * ($book ? (1 / $book->num_students_per_book) : 1)),
        ];
    }
}
