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
            FixCategory::updateOrCreate(['fix_category_code' => $category['fix_category_code']], $category);
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
                'fix_category_uuid' => Str::uuid()->toString(),
                'fix_category' => 'Retrofit y sustitución de componentes',
                'fix_category_code' => 'retrofit_sustitucion_componentes',
                'description' => 'Retrofit y sustitución de componentes',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'fix_category_uuid' => Str::uuid()->toString(),
                'fix_category' => 'Reparación de palas',
                'fix_category_code' => 'reparacion_palas',
                'description' => 'Reparación de palas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'fix_category_uuid' => Str::uuid()->toString(),
                'fix_category' => 'Reparaciones mediante plataforma y cuerdas',
                'fix_category_code' => 'reparacion_mediante_plataforma_cuerdas',
                'description' => 'Reparaciones mediante plataforma y cuerdas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'fix_category_uuid' => Str::uuid()->toString(),
                'fix_category' => 'Mantenimiento preventivo de palas',
                'fix_category_code' => 'mantenimiento_preventivo_palas',
                'description' => 'Mantenimiento preventivo de palas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'fix_category_uuid' => Str::uuid()->toString(),
                'fix_category' => 'Mantenimiento correctivo de palas',
                'fix_category_code' => 'mantenimiento_correctivo_palas',
                'description' => 'Mantenimiento correctivo de palas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'fix_category_uuid' => Str::uuid()->toString(),
                'fix_category' => 'Limpieza de palas',
                'fix_category_code' => 'limpieza_palas',
                'description' => 'Limpieza de palas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'fix_category_uuid' => Str::uuid()->toString(),
                'fix_category' => 'Mantenimiento correctivo de palas',
                'fix_category_code' => 'mantenimiento_correctivo_palas',
                'description' => 'Mantenimiento correctivo de palas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'fix_category_uuid' => Str::uuid()->toString(),
                'fix_category' => 'Reparación de daños en fibra de nacelle',
                'fix_category_code' => 'reparacion_danos_fibra_nacelle',
                'description' => 'Reparación de daños en fibra de nacelle',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'fix_category_uuid' => Str::uuid()->toString(),
                'fix_category' => 'Cambio de logotipo en la fibra de la nacelle',
                'fix_category_code' => 'cambio_logotipo_fibra_nacelle',
                'description' => 'Cambio de logotipo en la fibra de la nacelle',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'fix_category_uuid' => Str::uuid()->toString(),
                'fix_category' => 'Reparación de Torre',
                'fix_category_code' => 'reparacion_torre',
                'description' => 'Reparación de Torre',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
        ];
    }
}
