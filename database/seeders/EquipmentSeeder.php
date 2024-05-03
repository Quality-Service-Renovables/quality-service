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
        $trademarks = Trademark::all();
        $models = TrademarkModel::all();
        $status = Status::all();

        return [
            [
                'equipment_uuid' => Str::uuid()->toString(),
                'equipment' => 'Stipa Nayaa',
                'equipment_code' => 'stipa_nayaa',
                'equipment_image' => 'img/equipments/default.png',
                'equipment_diagram' => 'img/equipments/diagrams/gamesa_stipa_nayaa_ge2000pl.png',
                'serial_number' => '100307',
                'manufacture_date' => '2012-05-01',
                'work_hours' => '100307',
                'energy_produced' => '39815000',
                'barcode' => null,
                'description' => 'Turbina 07',
                'location' => 'Espinal, OAX.',
                'manual' => null,
                'equipment_category_id' => $equipmentCategories
                    ->where('equipment_category_code',
                        '=',
                        'multiplicador'
                    )->first()->equipment_category_id,
                'trademark_id' => $trademarks
                    ->where('trademark_code',
                        '=',
                        'gamesa'
                    )->first()->trademark_id,
                'trademark_model_id' => $models
                    ->where('trademark_model_code',
                        '=',
                        'ge2000pl'
                    )->first()->trademark_model_id,
                'status_id' => $status
                    ->where('status_code',
                        '=',
                        'operación'
                    )->first()->status_id,
                'active' => true,
            ],
            [
                'equipment_uuid' => Str::uuid()->toString(),
                'equipment' => 'Ingenio',
                'equipment_code' => 'ingenio',
                'equipment_image' => 'img/equipments/default.png',
                'equipment_diagram' => 'img/equipments/diagrams/indar_ingenio_plh_1100_3it70.png',
                'serial_number' => '58128',
                'manufacture_date' => '2012-05-01',
                'work_hours' => '897850',
                'energy_produced' => '11162694',
                'barcode' => null,
                'description' => 'Turbina A1.1',
                'location' => 'Santo Domingo Ingenio, OAX.',
                'manual' => null,
                'equipment_category_id' => $equipmentCategories
                    ->where('equipment_category_code',
                        '=',
                        'multiplicador'
                    )->first()->equipment_category_id,
                'trademark_id' => $trademarks
                    ->where('trademark_code',
                        '=',
                        'indar'
                    )->first()->trademark_id,
                'trademark_model_id' => $models
                    ->where('trademark_model_code',
                        '=',
                        'plh_1100_3it70'
                    )->first()->trademark_model_id,
                'status_id' => $status
                    ->where('status_code',
                        '=',
                        'operación'
                    )->first()->status_id,
                'active' => true,
            ],
        ];
    }
}
