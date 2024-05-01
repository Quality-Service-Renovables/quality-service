<?php

namespace Database\Seeders;

use App\Models\Failures\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FailureCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getFailures() as $failure) {
            Category::updateOrCreate([
                'failure_category_code' => $failure['failure_category_code']
            ], $failure);
        }
    }

    private function getFailures(): array
    {
        return [
            [
                'failure_category_uuid' => Str::uuid()->toString(),
                'failure_category' => 'General',
                'failure_category_code' => 'general',
                'description' => 'Falla de categoría general',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'failure_category_uuid' => Str::uuid()->toString(),
                'failure_category' => 'Retrofit y sustitución de componentes',
                'failure_category_code' => 'retrofit_sustitucion_componentes',
                'description' => 'Retrofit y sustitución de componentes',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'failure_category_uuid' => Str::uuid()->toString(),
                'failure_category' => 'Reparación de palas',
                'failure_category_code' => 'reparacion_palas',
                'description' => 'Reparación de palas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'failure_category_uuid' => Str::uuid()->toString(),
                'failure_category' => 'Reparaciones mediante plataforma y cuerdas',
                'failure_category_code' => 'reparacion_mediante_plataforma_cuerdas',
                'description' => 'Reparaciones mediante plataforma y cuerdas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'failure_category_uuid' => Str::uuid()->toString(),
                'failure_category' => 'Mantenimiento preventivo de palas',
                'failure_category_code' => 'mantenimiento_preventivo_palas',
                'description' => 'Mantenimiento preventivo de palas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'failure_category_uuid' => Str::uuid()->toString(),
                'failure_category' => 'Mantenimiento correctivo de palas',
                'failure_category_code' => 'mantenimiento_correctivo_palas',
                'description' => 'Mantenimiento correctivo de palas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'failure_category_uuid' => Str::uuid()->toString(),
                'failure_category' => 'Limpieza de palas',
                'failure_category_code' => 'limpieza_palas',
                'description' => 'Limpieza de palas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'failure_category_uuid' => Str::uuid()->toString(),
                'failure_category' => 'Mantenimiento correctivo de palas',
                'failure_category_code' => 'mantenimiento_correctivo_palas',
                'description' => 'Mantenimiento correctivo de palas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'failure_category_uuid' => Str::uuid()->toString(),
                'failure_category' => 'Reparación de daños en fibra de nacelle',
                'failure_category_code' => 'reparacion_danos_fibra_nacelle',
                'description' => 'Reparación de daños en fibra de nacelle',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'failure_category_uuid' => Str::uuid()->toString(),
                'failure_category' => 'Cambio de logotipo en la fibra de la nacelle',
                'failure_category_code' => 'cambio_logotipo_fibra_nacelle',
                'description' => 'Cambio de logotipo en la fibra de la nacelle',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'failure_category_uuid' => Str::uuid()->toString(),
                'failure_category' => 'Reparación de Torre',
                'failure_category_code' => 'reparacion_torre',
                'description' => 'Reparación de Torre',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
        ];
    }

}
