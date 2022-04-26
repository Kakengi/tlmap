<?php

namespace Database\Seeders;

use App\Models\Contract;
use App\Models\Publication;
use Illuminate\Database\Seeder;

class PublicationContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contract = Contract::findOrFail(1);
        $publications = Publication::limit(50)->get();
        foreach ($publications as $publication) {
            $contract->publication()->save($publication, [
                'quantity' => random_int(300000, 500000),
                'is_for_sale' => random_int(0, 1),
            ]);
        }
    }
}
