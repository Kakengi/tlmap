<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $authors = [
            "Taasisi ya Elimu Tanzania (TIE)",
            "Smarter",
            "Chinua Achebe",
            "Mc Millan",
            "Smith John"
        ];
        foreach ($authors as $author) {
            Author::create([
                'name' => $author,
            ]);
        }
    }
}
