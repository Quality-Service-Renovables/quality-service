<?php
/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace Database\Seeders;

use App\Models\Oils\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OilsCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getOils() as $oilCategory) {
            Category::updateOrCreate(['oil_category_code' => $oilCategory['oil_category_code']], [
                'oil_category_uuid' => $oilCategory['oil_category_uuid'],
                'oil_category' => $oilCategory['oil_category'],
                'description' => $oilCategory['description'],
            ]);
        }
    }

    /**
     * Get the oils.
     *
     * @return array The oils array.
     */
    private function getOils(): array
    {
        return [
            [
                'oil_category_uuid' => Str::uuid()->toString(),
                'oil_category' => 'Motor',
                'oil_category_code' => 'motor',
                'description' => 'Aceite de Motor',
            ],
            [
                'oil_category_uuid' => Str::uuid()->toString(),
                'oil_category' => 'Hidráulico',
                'oil_category_code' => 'hidraulico',
                'description' => 'Aceite Hidráulico',
            ],
            [
                'oil_category_uuid' => Str::uuid()->toString(),
                'oil_category' => 'Sintético',
                'oil_category_code' => 'sintetico',
                'description' => 'Aceite Sintético',
            ],
            [
                'oil_category_uuid' => Str::uuid()->toString(),
                'oil_category' => 'Transmisión',
                'oil_category_code' => 'transmision',
                'description' => 'Aceite para Transmisión',
            ],
            [
                'oil_category_uuid' => Str::uuid()->toString(),
                'oil_category' => 'Vegetal',
                'oil_category_code' => 'vegetal',
                'description' => 'Aceite Vegetal',
            ],
            [
                'oil_category_uuid' => Str::uuid()->toString(),
                'oil_category' => 'Diesel',
                'oil_category_code' => 'diesel',
                'description' => 'Aceite para Motores Diesel',
            ],
            [
                'oil_category_uuid' => Str::uuid()->toString(),
                'oil_category' => '2 Tiempos',
                'oil_category_code' => '2tiempos',
                'description' => 'Aceite para Motores de 2 Tiempos',
            ],
            [
                'oil_category_uuid' => Str::uuid()->toString(),
                'oil_category' => 'Compresor',
                'oil_category_code' => 'compresor',
                'description' => 'Aceite para Compresores',
            ],
            [
                'oil_category_uuid' => Str::uuid()->toString(),
                'oil_category' => 'Engranajes',
                'oil_category_code' => 'engranajes',
                'description' => 'Aceite para Engranajes',
            ],
        ];
    }
}
