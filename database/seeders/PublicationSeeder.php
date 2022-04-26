<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Publication;
use Illuminate\Database\Seeder;

class PublicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\Publication::factory(20)->create();
        for ($i = 0; $i < 20; $i++) {
            $book = Book::all()->random();
            $book_id = $book->id;
            $book_title = $book->title;
            $is_large_print = random_int(0, 1);
            $year = 2021;
            if (!Publication::where('book_id', $book_id)->where('is_large_print', $is_large_print)->where('publication_year', $year)->first())
                Publication::create([
                    'publication_title' => $book_title . " " . ($is_large_print ? " Large Print" : ""),
                    'book_id' => $book_id,
                    'author_id' => 1,
                    'number_of_pages' => random_int(150, 300),
                    'publication_year' => 2021,
                    'is_large_print' => $is_large_print,
                    'user_id' => 1,
                ]);
        }
    }
}
