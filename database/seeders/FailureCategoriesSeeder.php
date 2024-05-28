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
                'ct_failure_code' => $failure['ct_failure_code']
            ], $failure);
        }
    }

    private function getFailures(): array
    {
        return [
            [
                'ct_failure_uuid' => Str::uuid()->toString(),
                'ct_failure' => 'General',
                'ct_failure_code' => 'general',
                'description' => 'Falla de categoría general',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_failure_uuid' => Str::uuid()->toString(),
                'ct_failure' => 'Retrofit y sustitución de componentes',
                'ct_failure_code' => 'retrofit_sustitucion_componentes',
                'description' => 'Retrofit y sustitución de componentes',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_failure_uuid' => Str::uuid()->toString(),
                'ct_failure' => 'Reparación de palas',
                'ct_failure_code' => 'reparacion_palas',
                'description' => 'Reparación de palas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_failure_uuid' => Str::uuid()->toString(),
                'ct_failure' => 'Reparaciones mediante plataforma y cuerdas',
                'ct_failure_code' => 'reparacion_mediante_plataforma_cuerdas',
                'description' => 'Reparaciones mediante plataforma y cuerdas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_failure_uuid' => Str::uuid()->toString(),
                'ct_failure' => 'Mantenimiento preventivo de palas',
                'ct_failure_code' => 'mantenimiento_preventivo_palas',
                'description' => 'Mantenimiento preventivo de palas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_failure_uuid' => Str::uuid()->toString(),
                'ct_failure' => 'Mantenimiento correctivo de palas',
                'ct_failure_code' => 'mantenimiento_correctivo_palas',
                'description' => 'Mantenimiento correctivo de palas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_failure_uuid' => Str::uuid()->toString(),
                'ct_failure' => 'Limpieza de palas',
                'ct_failure_code' => 'limpieza_palas',
                'description' => 'Limpieza de palas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_failure_uuid' => Str::uuid()->toString(),
                'ct_failure' => 'Mantenimiento correctivo de palas',
                'ct_failure_code' => 'mantenimiento_correctivo_palas',
                'description' => 'Mantenimiento correctivo de palas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_failure_uuid' => Str::uuid()->toString(),
                'ct_failure' => 'Reparación de daños en fibra de nacelle',
                'ct_failure_code' => 'reparacion_danos_fibra_nacelle',
                'description' => 'Reparación de daños en fibra de nacelle',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_failure_uuid' => Str::uuid()->toString(),
                'ct_failure' => 'Cambio de logotipo en la fibra de la nacelle',
                'ct_failure_code' => 'cambio_logotipo_fibra_nacelle',
                'description' => 'Cambio de logotipo en la fibra de la nacelle',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_failure_uuid' => Str::uuid()->toString(),
                'ct_failure' => 'Reparación de Torre',
                'ct_failure_code' => 'reparacion_torre',
                'description' => 'Reparación de Torre',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
        ];
    }

}
