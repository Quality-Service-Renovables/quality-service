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
            Category::updateOrCreate(['ct_equipment_code' => $category['ct_equipment_code']], $category);
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
                'ct_equipment_uuid' => Str::uuid()->toString(),
                'ct_equipment' => 'Generadores',
                'ct_equipment_code' => 'generador',
                'description' => 'Generadores',
                'is_default' => true,
                'active' => true,
            ],
            [
                'ct_equipment_uuid' => Str::uuid()->toString(),
                'ct_equipment' => 'Multiplicadoras',
                'ct_equipment_code' => 'multiplicador',
                'description' => 'Multiplicadoras',
                'is_default' => true,
                'active' => true,
            ],
            [
                'ct_equipment_uuid' => Str::uuid()->toString(),
                'ct_equipment' => 'Transformadores',
                'ct_equipment_code' => 'transformador',
                'description' => 'Transformadores',
                'is_default' => true,
                'active' => true,
            ],
            [
                'ct_equipment_uuid' => Str::uuid()->toString(),
                'ct_equipment' => 'Equipos de inspección',
                'ct_equipment_code' => 'inspeccion',
                'description' => 'Equipos utilizados durante la inspección',
                'is_default' => true,
                'active' => true,
            ],
        ];
    }
}
