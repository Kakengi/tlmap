<?php

namespace Database\Seeders;

use App\Models\BookCategory;
use Illuminate\Database\Seeder;

class BookCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ["Kitabu cha Mwanafunzi", "Student Book"],
            ["Kiongozi cha Mwalimu", "Teacher's Guide"],
        ];
        foreach ($categories as $category) {
            BookCategory::create([
                'name_sw' => $category[0],
                'name_en' => $category[1]
            ]);
        }
    }
}
