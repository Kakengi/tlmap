<?php

namespace Database\Factories;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReceiptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $contract = Contract::find(1);
        $cp = $contract->publication->random()->pivot;
        $quantity = $cp->quantity;
        $quantity_per_box = random_int(40, 45);
        $number_of_boxes = floor($quantity / $quantity_per_box);
        $loose = $quantity % $quantity_per_box;
        return [
            'publication_contract_id' => $cp->id,
            'contract_id' => $cp->contract_id,
            'publication_id' => $cp->publication_id,
            'number_of_boxes' => $number_of_boxes,
            'quantity_per_box' => $quantity_per_box,
            'loose' => $loose,
            'gross_weight' => 10,
            'batch_id' => 1,
            'received_by' => 1,
        ];
    }
}
