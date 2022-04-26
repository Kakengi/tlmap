<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $company = $this->faker->company();
        $last_name = $this->faker->lastName();
        return [
            'name' => $company,
            'region_id' => 1,
            'district_id' => 3,
            'address' => $this->faker->address(),
            'phone_number' => '255713' . random_int(411330, 550000),
            'email' => Str::lower($this->faker->email()),
            'created_by' => 1
        ];
    }
}
