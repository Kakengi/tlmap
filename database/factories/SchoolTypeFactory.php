<?php

namespace Database\Factories;

use App\Models\SchoolType;
use Illuminate\Database\Eloquent\Factories\Factory;

class SchoolTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
       $types = [
                "Primary",
                "Secondary",
        ];
        foreach($types as $type){
            SchoolType::create([
                'name' => $type,
            ]);
        }
    }
}
