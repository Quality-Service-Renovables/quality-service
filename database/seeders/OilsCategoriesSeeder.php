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
            Category::updateOrCreate(['ct_oil_code' => $oilCategory['ct_oil_code']], [
                'ct_oil_uuid' => $oilCategory['ct_oil_uuid'],
                'ct_oil' => $oilCategory['ct_oil'],
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
                'ct_oil_uuid' => Str::uuid()->toString(),
                'ct_oil' => 'Motor',
                'ct_oil_code' => 'motor',
                'description' => 'Aceite de Motor',
            ],
            [
                'ct_oil_uuid' => Str::uuid()->toString(),
                'ct_oil' => 'Hidráulico',
                'ct_oil_code' => 'hidraulico',
                'description' => 'Aceite Hidráulico',
            ],
            [
                'ct_oil_uuid' => Str::uuid()->toString(),
                'ct_oil' => 'Sintético',
                'ct_oil_code' => 'sintetico',
                'description' => 'Aceite Sintético',
            ],
            [
                'ct_oil_uuid' => Str::uuid()->toString(),
                'ct_oil' => 'Transmisión',
                'ct_oil_code' => 'transmision',
                'description' => 'Aceite para Transmisión',
            ],
            [
                'ct_oil_uuid' => Str::uuid()->toString(),
                'ct_oil' => 'Vegetal',
                'ct_oil_code' => 'vegetal',
                'description' => 'Aceite Vegetal',
            ],
            [
                'ct_oil_uuid' => Str::uuid()->toString(),
                'ct_oil' => 'Diesel',
                'ct_oil_code' => 'diesel',
                'description' => 'Aceite para Motores Diesel',
            ],
            [
                'ct_oil_uuid' => Str::uuid()->toString(),
                'ct_oil' => '2 Tiempos',
                'ct_oil_code' => '2tiempos',
                'description' => 'Aceite para Motores de 2 Tiempos',
            ],
            [
                'ct_oil_uuid' => Str::uuid()->toString(),
                'ct_oil' => 'Compresor',
                'ct_oil_code' => 'compresor',
                'description' => 'Aceite para Compresores',
            ],
            [
                'ct_oil_uuid' => Str::uuid()->toString(),
                'ct_oil' => 'Engranajes',
                'ct_oil_code' => 'engranajes',
                'description' => 'Aceite para Engranajes',
            ],
        ];
    }
}
