<?php

namespace Database\Seeders;

use App\Models\BookCategory;
use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\ClassType;
use App\Models\SchoolClass;
use App\Models\Subject;
use database\factories\ClassTypeFactory;
use database\factories\SchoolFactory;
use database\factories\SchoolClassesFactory;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            BatchSeeder::class,
            RegionSeeder::class,
            DistrictSeeder::class,
            WardSeeder::class,
            SubjectSeeder::class,
            AuthorSeeder::class,
            BookCategorySeeder::class,
            UsersSeeder::class,
            SupplierSeeder::class,
            SchoolTypesSeeder::class,
            SchoolLevelsSeeder::class,
            SchoolClassesSeeder::class,
            SchoolSeeder::class,
            BookSeeder::class,
            SchoolRequirementsSeeder::class,
        ]);
        // \App\Models\SchoolRequirement::factory(20000)->create();
        \App\Models\User::factory(100)->create();
        $this->call([
            PublicationSeeder::class,
            ContractSeeder::class,
            PublicationContractSeeder::class,
        ]);
        \App\Models\Receipt::factory(10)->create();
    }
}
