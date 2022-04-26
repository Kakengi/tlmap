<?php

namespace Database\Factories;

use App\Models\Publication;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'supplier_id' => random_int(1, 8),
            'contract_number' => 'TIE-2021-B-' . $this->faker->randomElement([
                10000,
                10001,
                10002
            ]),
            'contract_title' => $this->faker->text(),
            'contract_year' =>  2021,
            'year_of_study' =>  2021,
            'delivery_date' => '2021-08-22',
            'user_id' => 3,
            'contract_status' =>  $this->faker->randomElement([
                'active',
                'closed'
            ])
        ];
    }
}
