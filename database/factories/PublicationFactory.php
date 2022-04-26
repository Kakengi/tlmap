<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\SchoolRequirement;
use Illuminate\Database\Eloquent\Factories\Factory;


class PublicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $req = SchoolRequirement::all()->radom();
        $Book = Book::where('school_class_id', $req->school_class_id)
            ->where('subject_id', $req->subject_id)->get()->random();
        return [
            'book_id' => $Book->id,
            'author_id' => 1,
            'number_of_pages' => random_int(150, 300),
            'publication_year' => 2021,
            'is_large_print' => random_int(0, 1),
            'user_id' => 1,
        ];
    }
}
