<?php

namespace Database\Seeders;

use App\Models\Equipments\Category;
use App\Models\Equipments\EquipmentCategory;
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
            Category::updateOrCreate(['equipment_category_code' => $category['equipment_category_code']], $category);
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
                'equipment_category_uuid' => Str::uuid()->toString(),
                'equipment_category' => 'Generadores',
                'equipment_category_code' => 'generador',
                'description' => 'Generadores',
                'is_default' => true,
                'active' => true,
            ],
            [
                'equipment_category_uuid' => Str::uuid()->toString(),
                'equipment_category' => 'Multiplicadoras',
                'equipment_category_code' => 'multiplicador',
                'description' => 'Multiplicadoras',
                'is_default' => true,
                'active' => true,
            ],
            [
                'equipment_category_uuid' => Str::uuid()->toString(),
                'equipment_category' => 'Transforamadores',
                'equipment_category_code' => 'transformador',
                'description' => 'Transformadores',
                'is_default' => true,
                'active' => true,
            ],
        ];
    }
}
