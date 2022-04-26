<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\School;
use App\Models\District;
use App\Models\Region;
use App\Models\SchoolLevel;
use App\Models\Ward;


class SchoolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = School::class;

    public function definition()
    {
        $school_level_id = SchoolLevel::all()->random()->id;
        return [
            'name' => $this->faker->firstName() . " " . (in_array($school_level_id, [1]) ? "Primary School" : "Secondary School"),
            'school_level_id' => $school_level_id,
            'registration_number' => random_int(1000, 100000),
            'school_type_id' => in_array($school_level_id, [1]) ? 1 : 2,
        ];
    }
}
