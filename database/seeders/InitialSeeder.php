<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            ClientsSeeder::class,
            StatusSeeder::class,
            UsersSeeder::class,
            ServiceCategoriesSeeder::class,
            MaintenanceCategoriesSeeder::class,
            FixCategoriesSeeder::class,
            InspectionCategoriesSeeder::class,
            VersionsSeeder::class,
        ]);
    }
}
