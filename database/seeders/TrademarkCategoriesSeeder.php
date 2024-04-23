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
            Category::updateOrCreate(['trademark_category_code' => $category['trademark_category_code']], [
                'trademark_category_uuid' => $category['trademark_category_uuid'],
                'trademark_category' => $category['trademark_category'],
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
                'trademark_category_uuid' => Str::uuid()->toString(),
                'trademark_category' => 'Equipos',
                'trademark_category_code' => 'equipos',
                'active' => true,
            ],
            [
                'trademark_category_uuid' => Str::uuid()->toString(),
                'trademark_category' => 'Aceites',
                'trademark_category_code' => 'aceites',
                'active' => true,
            ],
        ];
    }
}
