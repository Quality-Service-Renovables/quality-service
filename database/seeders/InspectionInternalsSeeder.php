<?php
/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace Database\Seeders;

use App\Models\Inspections\Categories\InspectionInternals;
use App\Models\Inspections\Categories\InspectionSections;
use App\Models\Inspections\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InspectionInternalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getInspectionInternals() as $inspectionInternal) {
            InspectionInternals::updateOrCreate([
                'ct_inspection_internal_code' => $inspectionInternal['ct_inspection_internal_code']
            ], $inspectionInternal);
        }
    }

    /**
     * Get the status array.
     *
     * @return array
     */
    private function getInspectionInternals(): array
    {
        $category = Category::all();
        $sections = InspectionSections::all();

        $systemCog = $sections
            ->where('ct_inspection_section_code', '=', 'inspeccion_engranajes')
            ->first()->ct_inspection_section_id;
        $systemSpare = $sections
            ->where('ct_inspection_section_code', '=', 'inspeccion_rodamientos')
            ->first()->ct_inspection_section_id;
        $systemField = $sections
            ->where('ct_inspection_section_code', '=', 'inspeccion_carcasas')
            ->first()->ct_inspection_section_id;
        $multiplicator = $category
            ->where('ct_inspection_code', '=', 'inspeccion_integral_estado_turbinas')
            ->first()->ct_inspection_id;
        return [
            [
                'ct_inspection_internal_uuid' => Str::uuid()->toString(),
                'ct_inspection_internal' => 'HSS',
                'ct_inspection_internal_code' => 'hss',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemCog,
            ],
            [
                'ct_inspection_internal_uuid' => Str::uuid()->toString(),
                'ct_inspection_internal' => 'IMS-LSS',
                'ct_inspection_internal_code' => 'ims_lss',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemCog,
            ],
            [
                'ct_inspection_internal_uuid' => Str::uuid()->toString(),
                'ct_inspection_internal' => 'IMS-HSS',
                'ct_inspection_internal_code' => 'ims_hss',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemCog,
            ],
            [
                'ct_inspection_internal_uuid' => Str::uuid()->toString(),
                'ct_inspection_internal' => 'LSS',
                'ct_inspection_internal_code' => 'lss',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemCog,
            ],
            [
                'ct_inspection_internal_uuid' => Str::uuid()->toString(),
                'ct_inspection_internal' => 'RING',
                'ct_inspection_internal_code' => 'ring',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemCog,
            ],
            [
                'ct_inspection_internal_uuid' => Str::uuid()->toString(),
                'ct_inspection_internal' => 'SUN',
                'ct_inspection_internal_code' => 'sun',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemCog,
            ],
            [
                'ct_inspection_internal_uuid' => Str::uuid()->toString(),
                'ct_inspection_internal' => 'SAT 1',
                'ct_inspection_internal_code' => 'sat_1',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemCog,
            ],
            [
                'ct_inspection_internal_uuid' => Str::uuid()->toString(),
                'ct_inspection_internal' => 'SAT 2',
                'ct_inspection_internal_code' => 'sat_2',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemCog,
            ],
            [
                'ct_inspection_internal_uuid' => Str::uuid()->toString(),
                'ct_inspection_internal' => 'SAT 3',
                'ct_inspection_internal_code' => 'sat_3',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemCog,
            ],
            [
                'ct_inspection_internal_uuid' => Str::uuid()->toString(),
                'ct_inspection_internal' => 'HSS-GEN',
                'ct_inspection_internal_code' => 'hss_gen',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemSpare,
            ],
            [
                'ct_inspection_internal_uuid' => Str::uuid()->toString(),
                'ct_inspection_internal' => 'HSS-ROT',
                'ct_inspection_internal_code' => 'hss_rot',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemSpare,
            ],
            [
                'ct_inspection_internal_uuid' => Str::uuid()->toString(),
                'ct_inspection_internal' => 'IMS-GEN',
                'ct_inspection_internal_code' => 'ims_gen',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemSpare,
            ],
            [
                'ct_inspection_internal_uuid' => Str::uuid()->toString(),
                'ct_inspection_internal' => 'IMS-ROT',
                'ct_inspection_internal_code' => 'ims_rot',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemSpare,
            ],
            [
                'ct_inspection_internal_uuid' => Str::uuid()->toString(),
                'ct_inspection_internal' => 'LSS-ROT',
                'ct_inspection_internal_code' => 'lss_rot',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemSpare,
            ],
            [
                'ct_inspection_internal_uuid' => Str::uuid()->toString(),
                'ct_inspection_internal' => 'LSS-GEN',
                'ct_inspection_internal_code' => 'lss_gen',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemSpare,
            ],
            [
                'ct_inspection_internal_uuid' => Str::uuid()->toString(),
                'ct_inspection_internal' => 'PC-ROT',
                'ct_inspection_internal_code' => 'pc_rot',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemSpare,
            ],
            [
                'ct_inspection_internal_uuid' => Str::uuid()->toString(),
                'ct_inspection_internal' => 'PC-GEN',
                'ct_inspection_internal_code' => 'pc_gen',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemSpare,
            ],
            [
                'ct_inspection_internal_uuid' => Str::uuid()->toString(),
                'ct_inspection_internal' => 'SAT A',
                'ct_inspection_internal_code' => 'sat_a',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemSpare,
            ],
            [
                'ct_inspection_internal_uuid' => Str::uuid()->toString(),
                'ct_inspection_internal' => 'SAT B',
                'ct_inspection_internal_code' => 'sat_b',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemSpare,
            ],
            [
                'ct_inspection_internal_uuid' => Str::uuid()->toString(),
                'ct_inspection_internal' => 'SAT C',
                'ct_inspection_internal_code' => 'sat_c',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemSpare,
            ],
            [
                'ct_inspection_internal_uuid' => Str::uuid()->toString(),
                'ct_inspection_internal' => 'Inspección Carcasa',
                'ct_inspection_internal_code' => 'inspeccion_carcasa',
                'ct_inspection_id' => $multiplicator,
                'ct_inspection_section_id' => $systemField,
            ],
        ];
    }
}
