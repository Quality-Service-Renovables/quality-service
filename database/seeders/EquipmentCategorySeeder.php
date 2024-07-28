<?php

namespace Database\Seeders;

use App\Models\Equipments\Category;
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
                'required_fields_report' => '',
                'is_default' => true,
                'active' => true,
            ],
            [
                'ct_equipment_uuid' => Str::uuid()->toString(),
                'ct_equipment' => 'Multiplicadoras',
                'ct_equipment_code' => 'multiplicador',
                'description' => 'Multiplicadoras',
                'required_fields_report' => json_encode([
                    "fields" => [
                        [
                            "key" => "tipo_turbina",
                            "name" => "Tipo de turbina",
                            "type" => "string",
                            "required" => false,
                        ],
                        [
                            "key" => "marca",
                            "name" => "Marca",
                            "type" => "string",
                            "required" => false,
                        ],
                        [
                            "key" => "modelo",
                            "name" => "Modelo",
                            "type" => "string",
                            "required" => false,
                        ],
                        [
                            "key" => "numero_serie",
                            "name" => "Número de serie",
                            "type" => "string",
                            "required" => false,
                        ],
                        [
                            "key" => "potencia",
                            "name" => "Potencia",
                            "type" => "string",
                            "required" => false,
                        ],
                        [
                            "key" => "marca_de_aceite",
                            "name" => "Marca de aceite",
                            "type" => "string",
                            "required" => false,
                        ],
                    ],
                ]),
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
        ];
    }
}
