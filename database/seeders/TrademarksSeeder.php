<?php
/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace Database\Seeders;

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
     *
     * @return array
     */
    private function getTrademarks(): array
    {
        return [
            [
                'trademark_uuid' => Str::uuid()->toString(),
                'trademark' => 'Generic',
                'trademark_code' => 'generic',
                'active' => true,
                'models' => [
                    [
                        'trademark_model' => 'Generic',
                        'trademark_model_code' => 'generic',
                    ],
                ],
            ],
            [
                'trademark_uuid' => Str::uuid()->toString(),
                'trademark' => 'Winergy',
                'trademark_code' => 'winergy',
                'active' => true,
                'models' => [],
            ],
        ];
    }
}
