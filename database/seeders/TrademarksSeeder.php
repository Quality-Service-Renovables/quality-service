<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace Database\Seeders;

use App\Models\Trademarks\Category;
use App\Models\Trademarks\Trademark;
use App\Models\Trademarks\TrademarkModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TrademarksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getTrademarks() as $trademark) {
            $trademarkRegister = Trademark::updateOrCreate(['trademark_code' => $trademark['trademark_code']], [
                'trademark_uuid' => $trademark['trademark_uuid'],
                'trademark' => $trademark['trademark'],
                'trademark_code' => $trademark['trademark_code'],
                'ct_trademark_id' => $trademark['ct_trademark_id'],
                'active' => $trademark['active'],
            ]);
            foreach ($trademark['models'] as $model) {
                TrademarkModel::updateOrCreate(['trademark_model_code' => $model['trademark_model_code']], [
                    'trademark_model_uuid' => Str::uuid(),
                    'trademark_model' => $model['trademark_model'],
                    'trademark_id' => $trademarkRegister->trademark_id,
                ]);
            }
        }
    }

    /**
     * Get the array of trademarks.
     */
    private function getTrademarks(): array
    {
        return array_merge($this->getEquipmentsTrademarks(), $this->getOilTrademarks());
    }

    private function getEquipmentsTrademarks(): array
    {
        $equipmentCategory = Category::where('ct_trademark_code', 'equipos')->first()->ct_trademark_id;

        return [
            [
                'trademark_uuid' => Str::uuid()->toString(),
                'trademark' => 'Marca Genérica',
                'trademark_code' => 'generic_equipment',
                'ct_trademark_id' => $equipmentCategory,
                'active' => true,
                'models' => [
                    [
                        'trademark_model' => 'Modelo Genérico',
                        'trademark_model_code' => 'generic_model_equipment',
                    ],
                ],
            ],
            [
                'trademark_uuid' => Str::uuid()->toString(),
                'trademark' => 'Winergy',
                'trademark_code' => 'winergy',
                'ct_trademark_id' => $equipmentCategory,
                'active' => true,
                'models' => [],
            ],
            [
                'trademark_uuid' => Str::uuid()->toString(),
                'trademark' => 'Gamesa',
                'trademark_code' => 'gamesa',
                'ct_trademark_id' => $equipmentCategory,
                'active' => true,
                'models' => [
                    [
                        'trademark_model' => 'GE2000PL',
                        'trademark_model_code' => 'ge2000pl',
                    ],
                ],
            ],
            [
                'trademark_uuid' => Str::uuid()->toString(),
                'trademark' => 'Indar',
                'trademark_code' => 'indar',
                'ct_trademark_id' => $equipmentCategory,
                'active' => true,
                'models' => [
                    [
                        'trademark_model' => '  PLH-1100.3IT70',
                        'trademark_model_code' => 'plh_1100_3it70',
                    ],
                ],
            ],
        ];
    }

    private function getOilTrademarks(): array
    {
        $oilCategory = Category::where('ct_trademark_code', 'aceites')->first()->ct_trademark_id;

        return [
            [
                'trademark_uuid' => Str::uuid()->toString(),
                'trademark' => 'Aceite Genérico',
                'trademark_code' => 'generic_oil',
                'ct_trademark_id' => $oilCategory,
                'active' => true,
                'models' => [
                    [
                        'trademark_model' => 'Modelo Genérico de Aceite',
                        'trademark_model_code' => 'generic_model_oil',
                    ],
                ],
            ],
            [
                'trademark_uuid' => Str::uuid()->toString(),
                'trademark' => 'Castrol',
                'trademark_code' => 'castrol',
                'ct_trademark_id' => $oilCategory,
                'active' => true,
                'models' => [],
            ],
            [
                'trademark_uuid' => Str::uuid()->toString(),
                'trademark' => 'Mobil',
                'trademark_code' => 'mobil',
                'ct_trademark_id' => $oilCategory,
                'active' => true,
                'models' => [],
            ],
            [
                'trademark_uuid' => Str::uuid()->toString(),
                'trademark' => 'Shell',
                'trademark_code' => 'shell',
                'ct_trademark_id' => $oilCategory,
                'active' => true,
                'models' => [],
            ],
            [
                'trademark_uuid' => Str::uuid()->toString(),
                'trademark' => 'Valvoline',
                'trademark_code' => 'valvoline',
                'ct_trademark_id' => $oilCategory,
                'active' => true,
                'models' => [],
            ],
        ];
    }
}
