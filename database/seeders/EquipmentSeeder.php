<?php

namespace Database\Seeders;

use App\Models\Equipments\Category;
use App\Models\Equipments\Equipment;
use App\Models\Status\Status;
use App\Models\Trademarks\Trademark;
use App\Models\Trademarks\TrademarkModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getEquipments() as $equipment) {
            Equipment::updateOrCreate(['equipment_code' => $equipment['equipment_code']], $equipment);
        }
    }

    /**
     * Retrieve the equipment categories.
     *
     * @return array The equipment categories.
     */
    public function getEquipments(): array
    {
        $equipmentCategories = Category::all();
        $status = Status::all();

        return [
            [
                'equipment_uuid' => Str::uuid()->toString(),
                'equipment' => 'Boroscopio',
                'equipment_code' => 'boroscopio',
                'trademark' => '',
                'model' => '',
                'equipment_image' => 'img/equipments/default.png',
                'equipment_diagram' => '',
                'serial_number' => '12345',
                'manual' => null,
                'ct_equipment_id' => $equipmentCategories
                    ->where('ct_equipment_code',
                        '=',
                        'multiplicador'
                    )->first()->ct_equipment_id,
                'status_id' => $status
                    ->where('status_code',
                        '=',
                        'operacion'
                    )->first()->status_id,
                'active' => true,
            ],
            [
                'equipment_uuid' => Str::uuid()->toString(),
                'equipment' => 'Endoscopio',
                'equipment_code' => 'endoscopio',
                'trademark' => '',
                'model' => '',
                'equipment_image' => 'img/equipments/default.png',
                'equipment_diagram' => '',
                'serial_number' => '54321',
                'manual' => null,
                'ct_equipment_id' => $equipmentCategories
                    ->where('ct_equipment_code',
                        '=',
                        'multiplicador'
                    )->first()->ct_equipment_id,
                'status_id' => $status
                    ->where('status_code',
                        '=',
                        'operacion'
                    )->first()->status_id,
                'active' => true,
            ],
        ];
    }
}
