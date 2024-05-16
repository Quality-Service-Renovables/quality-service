<?php /** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace Database\Seeders;

use App\Models\Inspections\Categories\InspectionExternals;
use App\Models\Inspections\Categories\InspectionSections;
use App\Models\Inspections\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InspectionExternalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getInspectionExternals() as $inspectionInternal) {
            InspectionExternals::updateOrCreate([
                'ct_inspection_external_code' => $inspectionInternal['ct_inspection_external_code']
            ], $inspectionInternal);
        }
    }

    /**
     * Get the status array.
     *
     * @return array
     */
    private function getInspectionExternals(): array
    {
        $category = Category::all();
        $sections = InspectionSections::all();
        //sistema_refrigeracion,sistema_lubricacion_filtrado,otros_componentes
        $systemCooler = $sections
            ->where('ct_inspection_section_code', '=', 'sistema_refrigeracion')
            ->first()->ct_inspection_section_id;
        $systemLubrication = $sections
            ->where('ct_inspection_section_code', '=', 'sistema_lubricacion_filtrado')
            ->first()->ct_inspection_section_id;
        $systemOther = $sections
            ->where('ct_inspection_section_code', '=', 'otros_componentes')
            ->first()->ct_inspection_section_id;
        $multiplicator = $category
            ->where('ct_inspection_code', '=', 'inspeccion_integral_estado_turbinas')
            ->first()->ct_inspection_id;
        return [
            [
                'ct_inspection_external_uuid' => Str::uuid()->toString(),
                'ct_inspection_external' => 'Estado del intercambiador',
                'ct_inspection_external_code' => 'estado_intercambiador',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemCooler,
            ],
            [
                'ct_inspection_external_uuid' => Str::uuid()->toString(),
                'ct_inspection_external' => 'Funcionamiento del ventiladores',
                'ct_inspection_external_code' => 'funcionamiento_ventiladores',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemCooler,
            ],
            [
                'ct_inspection_external_uuid' => Str::uuid()->toString(),
                'ct_inspection_external' => 'Funcionamiento de la bomba Eléctrica',
                'ct_inspection_external_code' => 'funcionamiento_bomba_electrica',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemCooler,
            ],
            [
                'ct_inspection_external_uuid' => Str::uuid()->toString(),
                'ct_inspection_external' => 'Fugas en sistema de refrigeración',
                'ct_inspection_external_code' => 'fugas_sistema_refrigeracion',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemLubrication,
            ],
            [
                'ct_inspection_external_uuid' => Str::uuid()->toString(),
                'ct_inspection_external' => 'Tipo de aceite',
                'ct_inspection_external_code' => 'tipo_aceite',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemLubrication,
            ],
            [
                'ct_inspection_external_uuid' => Str::uuid()->toString(),
                'ct_inspection_external' => 'Verificación filtro aire',
                'ct_inspection_external_code' => 'verficacion_filtro_aire',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemLubrication,
            ],
            [
                'ct_inspection_external_uuid' => Str::uuid()->toString(),
                'ct_inspection_external' => 'Nivel aceite',
                'ct_inspection_external_code' => 'nivel_aceite',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemLubrication,
            ],
            [
                'ct_inspection_external_uuid' => Str::uuid()->toString(),
                'ct_inspection_external' => 'Inspección visual del aceite',
                'ct_inspection_external_code' => 'inspeccion_visual_aceite',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemLubrication,
            ],
            [
                'ct_inspection_external_uuid' => Str::uuid()->toString(),
                'ct_inspection_external' => 'Análisis de aceite',
                'ct_inspection_external_code' => 'analisis_aceite',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemLubrication,
            ],
            [
                'ct_inspection_external_uuid' => Str::uuid()->toString(),
                'ct_inspection_external' => 'Funcionamiento del filtro on-line',
                'ct_inspection_external_code' => 'funcionamiento_filtro_on_line',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemLubrication,
            ],
            [
                'ct_inspection_external_uuid' => Str::uuid()->toString(),
                'ct_inspection_external' => 'Funcionamiento sistema filtrado off-line',
                'ct_inspection_external_code' => 'funcionamiento_sistema_filtrado_off_line',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemLubrication,
            ],
            [
                'ct_inspection_external_uuid' => Str::uuid()->toString(),
                'ct_inspection_external' => 'Fugas sistema de lubricación y filtrado',
                'ct_inspection_external_code' => 'fugas_sistema_lubricación_filtrado',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemLubrication,
            ],
            [
                'ct_inspection_external_uuid' => Str::uuid()->toString(),
                'ct_inspection_external' => 'Sistema de amortiguadores',
                'ct_inspection_external_code' => 'sistema_amortiguadores',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemOther,
            ],
            [
                'ct_inspection_external_uuid' => Str::uuid()->toString(),
                'ct_inspection_external' => 'Juntas',
                'ct_inspection_external_code' => 'juntas',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemOther,
            ],
            [
                'ct_inspection_external_uuid' => Str::uuid()->toString(),
                'ct_inspection_external' => 'Sensores temperatura',
                'ct_inspection_external_code' => 'sensores_temperatura',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemOther,
            ],
            [
                'ct_inspection_external_uuid' => Str::uuid()->toString(),
                'ct_inspection_external' => 'Sensores de vibraciones',
                'ct_inspection_external_code' => 'sensores_vibraciones',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemOther,
            ],
            [
                'ct_inspection_external_uuid' => Str::uuid()->toString(),
                'ct_inspection_external' => 'Virutas imán multiplicadora',
                'ct_inspection_external_code' => 'virutas_iman_multiplicadora',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemOther,
            ],
            [
                'ct_inspection_external_uuid' => Str::uuid()->toString(),
                'ct_inspection_external' => 'Viruta dentro de la multiplicadora',
                'ct_inspection_external_code' => 'viruta_dentro_multiplicadora',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemOther,
            ],
            [
                'ct_inspection_external_uuid' => Str::uuid()->toString(),
                'ct_inspection_external' => 'Fuga tapas uniones y/o tapas multiplicadora',
                'ct_inspection_external_code' => 'fuga_tapas_uniones_tapas_multiplicadora',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemOther,
            ],
        ];
    }
}
