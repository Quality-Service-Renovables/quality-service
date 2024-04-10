<?php /** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace Database\Seeders;

use App\Models\InspectionCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InspectionCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getCategories() as $category) {
            InspectionCategory::updateOrCreate(['inspection_category_code' => $category['inspection_category_code']], $category);
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
                'inspection_category_uuid' => Str::uuid()->toString(),
                'inspection_category' => 'Inspecciones termográficas y boroscópicas',
                'inspection_category_code' => 'inspeccion_termografica_boroscopica',
                'description' => 'Inspecciones termográficas y boroscópicas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'inspection_category_uuid' => Str::uuid()->toString(),
                'inspection_category' => 'Megados y comprobaciones eléctricas',
                'inspection_category_code' => 'megados_comprobaciones_electricas',
                'description' => 'Megados y comprobaciones eléctricas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'inspection_category_uuid' => Str::uuid()->toString(),
                'inspection_category' => 'Inspección integral de estado de turbinas',
                'inspection_category_code' => 'inspeccion_integral_estado_turbinas',
                'description' => 'Inspección integral de estado de turbinas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'inspection_category_uuid' => Str::uuid()->toString(),
                'inspection_category' => 'Inspección de calidad en el montaje',
                'inspection_category_code' => 'inspeccion_calidad_montaje',
                'description' => 'Inspección de calidad en el montaje',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'inspection_category_uuid' => Str::uuid()->toString(),
                'inspection_category' => 'Inspección de fin de garantía',
                'inspection_category_code' => 'inspeccion_fin_garantia',
                'description' => 'Inspección de fin de garantía',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'inspection_category_uuid' => Str::uuid()->toString(),
                'inspection_category' => 'Inspección de calidad en el montaje',
                'inspection_category_code' => 'inspeccion_calidad_montaje',
                'description' => 'Inspección de calidad en el montaje',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'inspection_category_uuid' => Str::uuid()->toString(),
                'inspection_category' => 'Inspecciones de palas',
                'inspection_category_code' => 'inspeccion_palas',
                'description' => 'Inspecciones de palas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'inspection_category_uuid' => Str::uuid()->toString(),
                'inspection_category' => 'Inspección y tomas fotográficas desde el suelo',
                'inspection_category_code' => 'inspeccion_tomas_fotografica_suelo',
                'description' => 'Inspección y tomas fotográficas desde el suelo',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'inspection_category_uuid' => Str::uuid()->toString(),
                'inspection_category' => 'Inspección en altura',
                'inspection_category_code' => 'inspeccion_altura',
                'description' => 'Inspección en altura',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'inspection_category_uuid' => Str::uuid()->toString(),
                'inspection_category' => 'Inspección mediante robot ',
                'inspection_category_code' => 'inspeccion_mediante_robot',
                'description' => 'Inspección mediante robot ',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
        ];
    }
}
