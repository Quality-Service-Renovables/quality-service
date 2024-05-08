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
            RolsSeeder::class,
            ClientsSeeder::class,
            PermissionSeeder::class,
            StatusSeeder::class,
            UsersSeeder::class,
            ServiceCategoriesSeeder::class,
            MaintenanceCategoriesSeeder::class,
            FixCategoriesSeeder::class,
            EquipmentCategorySeeder::class,
            FailureCategoriesSeeder::class,
            InspectionCategoriesSeeder::class,
            TrademarkCategoriesSeeder::class,
            TrademarksSeeder::class,
            OilsCategoriesSeeder::class,
            EquipmentSeeder::class,
            VersionsSeeder::class,
        ]);
    }
}
