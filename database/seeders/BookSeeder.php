<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\BookCategory;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 50; $i++) {
            $BookCategory = BookCategory::find(1);
            $Subject = Subject::all()->random();
            $SchoolClass = SchoolClass::all()->random();
            $subject_id = $Subject->id;
            $category_id = $BookCategory->id;
            $class_id = $SchoolClass->id;
            $subject_name = $Subject->name;
            $category_name = $BookCategory->name_sw;
            $class_name = $SchoolClass->name;

            if (!Book::where('subject_id', $subject_id)->where('book_category_id', $category_id)->where('school_class_id', $class_id)->first())
                Book::create([
                    'title' => $subject_name . ' ' . $category_name . ' ' . $class_name,
                    'subject_id' => $subject_id,
                    'school_class_id' => $class_id,
                    'book_category_id' => $category_id,
                    'num_students_per_book' => random_int(1, 4),
                    'user_id' => 1,
                ]);
        }
    }
}
