<?php /** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace Database\Seeders;

use App\Models\Inspections\Categories\CtInspection;
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
            CtInspection::updateOrCreate(['ct_inspection_code' => $category['ct_inspection_code']], $category);
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
                'ct_inspection_uuid' => Str::uuid()->toString(),
                'ct_inspection' => 'Inspecciones termográficas y boroscópicas',
                'ct_inspection_code' => 'inspeccion_termografica_boroscopica',
                'description' => 'Inspecciones termográficas y boroscópicas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_inspection_uuid' => Str::uuid()->toString(),
                'ct_inspection' => 'Megados y comprobaciones eléctricas',
                'ct_inspection_code' => 'megados_comprobaciones_electricas',
                'description' => 'Megados y comprobaciones eléctricas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_inspection_uuid' => Str::uuid()->toString(),
                'ct_inspection' => 'Inspección integral de estado de turbinas',
                'ct_inspection_code' => 'inspeccion_integral_estado_turbinas',
                'description' => 'Inspección integral de estado de turbinas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_inspection_uuid' => Str::uuid()->toString(),
                'ct_inspection' => 'Inspección de calidad en el montaje',
                'ct_inspection_code' => 'inspeccion_calidad_montaje',
                'description' => 'Inspección de calidad en el montaje',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_inspection_uuid' => Str::uuid()->toString(),
                'ct_inspection' => 'Inspección de fin de garantía',
                'ct_inspection_code' => 'inspeccion_fin_garantia',
                'description' => 'Inspección de fin de garantía',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_inspection_uuid' => Str::uuid()->toString(),
                'ct_inspection' => 'Inspección de calidad en el montaje',
                'ct_inspection_code' => 'inspeccion_calidad_montaje',
                'description' => 'Inspección de calidad en el montaje',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_inspection_uuid' => Str::uuid()->toString(),
                'ct_inspection' => 'Inspecciones de palas',
                'ct_inspection_code' => 'inspeccion_palas',
                'description' => 'Inspecciones de palas',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_inspection_uuid' => Str::uuid()->toString(),
                'ct_inspection' => 'Inspección y tomas fotográficas desde el suelo',
                'ct_inspection_code' => 'inspeccion_tomas_fotografica_suelo',
                'description' => 'Inspección y tomas fotográficas desde el suelo',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_inspection_uuid' => Str::uuid()->toString(),
                'ct_inspection' => 'Inspección en altura',
                'ct_inspection_code' => 'inspeccion_altura',
                'description' => 'Inspección en altura',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_inspection_uuid' => Str::uuid()->toString(),
                'ct_inspection' => 'Inspección mediante robot ',
                'ct_inspection_code' => 'inspeccion_mediante_robot',
                'description' => 'Inspección mediante robot ',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_inspection_uuid' => Str::uuid()->toString(),
                'ct_inspection' => 'Inspección de multiplicadora',
                'ct_inspection_code' => 'inspeccion_multiplicadora',
                'description' => 'Esta inspección incluye verificar el estado de los engranajes, rodamientos, lubricación, posibles desgastes o daños y asegurarse de que todos los componentes estén funcionando correctamente y sin vibraciones anormales.',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
        ];
    }
}
