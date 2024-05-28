<?php /** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace Database\Seeders;

use App\Models\Fixs\FixCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FixCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getCategories() as $category) {
            FixCategory::updateOrCreate(['ct_fix_code' => $category['ct_fix_code']], $category);
        }
    }

    /**
     * Get the status array.
     *
     * @return array
     */
    private function getCategories(): array
    {
        return [
            [
                'ct_fix_uuid' => Str::uuid()->toString(),
                'ct_fix' => 'Retrofit y sustitución de componentes',
                'ct_fix_code' => 'retrofit_sustitucion_componentes',
                'description' => 'Retrofit y sustitución de componentes',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_fix_uuid' => Str::uuid()->toString(),
                'ct_fix' => 'Reparación de palas',
                'ct_fix_code' => 'reparacion_palas',
                'description' => 'Reparación de palas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_fix_uuid' => Str::uuid()->toString(),
                'ct_fix' => 'Reparaciones mediante plataforma y cuerdas',
                'ct_fix_code' => 'reparacion_mediante_plataforma_cuerdas',
                'description' => 'Reparaciones mediante plataforma y cuerdas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_fix_uuid' => Str::uuid()->toString(),
                'ct_fix' => 'Mantenimiento preventivo de palas',
                'ct_fix_code' => 'mantenimiento_preventivo_palas',
                'description' => 'Mantenimiento preventivo de palas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_fix_uuid' => Str::uuid()->toString(),
                'ct_fix' => 'Mantenimiento correctivo de palas',
                'ct_fix_code' => 'mantenimiento_correctivo_palas',
                'description' => 'Mantenimiento correctivo de palas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_fix_uuid' => Str::uuid()->toString(),
                'ct_fix' => 'Limpieza de palas',
                'ct_fix_code' => 'limpieza_palas',
                'description' => 'Limpieza de palas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_fix_uuid' => Str::uuid()->toString(),
                'ct_fix' => 'Mantenimiento correctivo de palas',
                'ct_fix_code' => 'mantenimiento_correctivo_palas',
                'description' => 'Mantenimiento correctivo de palas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_fix_uuid' => Str::uuid()->toString(),
                'ct_fix' => 'Reparación de daños en fibra de nacelle',
                'ct_fix_code' => 'reparacion_danos_fibra_nacelle',
                'description' => 'Reparación de daños en fibra de nacelle',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_fix_uuid' => Str::uuid()->toString(),
                'ct_fix' => 'Cambio de logotipo en la fibra de la nacelle',
                'ct_fix_code' => 'cambio_logotipo_fibra_nacelle',
                'description' => 'Cambio de logotipo en la fibra de la nacelle',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_fix_uuid' => Str::uuid()->toString(),
                'ct_fix' => 'Reparación de Torre',
                'ct_fix_code' => 'reparacion_torre',
                'description' => 'Reparación de Torre',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
        ];
    }
}
