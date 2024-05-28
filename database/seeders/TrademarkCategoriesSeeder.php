<?php
/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace Database\Seeders;

use App\Models\Trademarks\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TrademarkCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getTrademarks() as $category) {
            Category::updateOrCreate(['ct_trademark_code' => $category['ct_trademark_code']], [
                'ct_trademark_uuid' => $category['ct_trademark_uuid'],
                'ct_trademark' => $category['ct_trademark'],
                'active' => $category['active'],
            ]);
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
                'ct_trademark_uuid' => Str::uuid()->toString(),
                'ct_trademark' => 'Equipos',
                'ct_trademark_code' => 'equipos',
                'active' => true,
            ],
            [
                'ct_trademark_uuid' => Str::uuid()->toString(),
                'ct_trademark' => 'Aceites',
                'ct_trademark_code' => 'aceites',
                'active' => true,
            ],
        ];
    }
}
