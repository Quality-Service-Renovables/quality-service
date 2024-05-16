<?php /** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace Database\Seeders;

use App\Models\Inspections\Categories\InspectionSections;
use App\Models\Inspections\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InspectionSectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getInspectionSections() as $inspectionSection) {
            InspectionSections::updateOrCreate([
                'ct_inspection_section_code' => $inspectionSection['ct_inspection_section_code']
            ], $inspectionSection);
        }
    }

    /**
     * Get the status array.
     *
     * @return array
     */
    private function getInspectionSections(): array
    {
        $category = Category::all();
        $multiplicator = $category
            ->where('ct_inspection_code', '=', 'inspeccion_integral_estado_turbinas')
            ->first()->ct_inspection_id;
        return [
            [
                'ct_inspection_section_uuid' => Str::uuid()->toString(),
                'ct_inspection_section' => 'Sistema Refrigeración',
                'ct_inspection_section_code' => 'sistema_refrigeracion',
                'ct_inspection_id' => $multiplicator,
            ],
            [
                'ct_inspection_section_uuid' => Str::uuid()->toString(),
                'ct_inspection_section' => 'Sistema lubricación y filtrado',
                'ct_inspection_section_code' => 'sistema_lubricacion_filtrado',
                'ct_inspection_id' => $multiplicator,
            ],
            [
                'ct_inspection_section_uuid' => Str::uuid()->toString(),
                'ct_inspection_section' => 'Otros componentes',
                'ct_inspection_section_code' => 'otros_componentes',
                'ct_inspection_id' => $multiplicator,
            ],
            [
                'ct_inspection_section_uuid' => Str::uuid()->toString(),
                'ct_inspection_section' => 'Inspección Engranajes',
                'ct_inspection_section_code' => 'inspeccion_engranajes',
                'ct_inspection_id' => $multiplicator,
            ],
            [
                'ct_inspection_section_uuid' => Str::uuid()->toString(),
                'ct_inspection_section' => 'Inspección de Rodamientos',
                'ct_inspection_section_code' => 'inspeccion_rodamientos',
                'ct_inspection_id' => $multiplicator,
            ],
            [
                'ct_inspection_section_uuid' => Str::uuid()->toString(),
                'ct_inspection_section' => 'Inspección de Carcasas',
                'ct_inspection_section_code' => 'inspeccion_carcasas',
                'ct_inspection_id' => $multiplicator,
            ],
        ];
    }
}
