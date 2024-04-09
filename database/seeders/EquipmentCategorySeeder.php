<?php

namespace Database\Seeders;

use App\Models\EquipmentCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EquipmentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getCategories() as $category) {
            EquipmentCategory::updateOrCreate(['equipment_catergory_code' => $category['equipment_catergory_code']], $category);
        }
    }

    /**
     * Retrieve the equipment categories.
     *
     * @return array The equipment categories.
     */
    public function getCategories(): array
    {
        return [
            [
                'equipment_catergory_uuid' => Str::uuid()->toString(),
                'equipment_catergory' => '',
                'equipment_catergory_code' => '',
                'description' => '',
                'active' => true,
            ],
        ];
    }
}
