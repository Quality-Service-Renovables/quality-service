<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace Database\Seeders;

use App\Models\Inspections\Categories\Section;
use App\Models\Inspections\Category;
use App\Models\Inspections\CategoryForm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InspectionSectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // SECTION
        foreach ($this->getInspectionSections() as $section) {
            $inspectionSection = Section::updateOrCreate([
                'ct_inspection_section_code' => $section['ct_inspection_section_code'],
            ], [
                'ct_inspection_section_uuid' => $section['ct_inspection_section_uuid'],
                'ct_inspection_section' => $section['ct_inspection_section'],
                'ct_inspection_id' => $section['ct_inspection_id'],
            ]);
            // SUB SECTION
            foreach ($section['sub_sections'] as $subSection) {
                $inspectionSubSection = Section::updateOrCreate([
                    'ct_inspection_section_code' => $subSection['ct_inspection_section_code'],
                ], [
                    'ct_inspection_section_uuid' => $subSection['ct_inspection_section_uuid'],
                    'ct_inspection_section' => $subSection['ct_inspection_section'],
                    'ct_inspection_id' => $subSection['ct_inspection_id'],
                    'ct_inspection_relation_id' => $inspectionSection->ct_inspection_section_id,
                ]);
                // FIELDS
                foreach ($subSection['fields'] as $field) {
                    $field['ct_inspection_section_id'] = $inspectionSubSection->ct_inspection_section_id;
                    CategoryForm::updateOrCreate([
                        'ct_inspection_form_code' => $field['ct_inspection_form_code'],
                    ], $field);
                }
            }
        }
    }

    /**
     * Get the status array.
     */
    private function getInspectionSections(): array
    {
        $category = Category::all();
        $multiplicator = $category
            ->where('ct_inspection_code', '=', 'inspeccion_integral_estado_turbinas')
            ->first()->ct_inspection_id;

        return [
            // SECTION EXTERNAL
            [
                'ct_inspection_section_uuid' => Str::uuid()->toString(),
                'ct_inspection_section' => 'Inspección Externa',
                'ct_inspection_section_code' => 'inspeccion_externa',
                'ct_inspection_id' => $multiplicator,
                'sub_sections' => [
                    [
                        // SUB SECTION: SISTEMA DE REFRIGERACIÓN
                        'ct_inspection_section_uuid' => Str::uuid()->toString(),
                        'ct_inspection_section' => 'Sistema Refrigeración',
                        'ct_inspection_section_code' => 'sistema_refrigeracion',
                        'ct_inspection_id' => $multiplicator,
                        // FIELDS: SISTEMA DE REFRIGERACIÓN
                        'fields' => [
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'Estado del Intercambiador',
                                'ct_inspection_form_code' => 'estado_intercambiador',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'Funcionamiento de Ventiladores',
                                'ct_inspection_form_code' => 'funcionamiento_ventiladores',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'Funcionamiento Bomba Eléctrica',
                                'ct_inspection_form_code' => 'funcionamiento_bomba_electrica',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'Fugas en Sistema de Refrigeración',
                                'ct_inspection_form_code' => 'fugas_sistema_refrigeracion',
                            ],
                        ],
                        // END FIELDS: SISTEMA DE REFRIGERACIÓN
                    ],
                    // END SUB SECTION: SISTEMA REFRIGERACIÓN
                    // SUB SECTION: SISTEMA DE LUBRICACIÓN
                    [
                        'ct_inspection_section_uuid' => Str::uuid()->toString(),
                        'ct_inspection_section' => 'Sistema lubricación y filtrado',
                        'ct_inspection_section_code' => 'sistema_lubricacion_filtrado',
                        'ct_inspection_id' => $multiplicator,
                        // FIELDS: SISTEMA DE LUBRICACIÓN
                        'fields' => [
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'Tipo de Aceite',
                                'ct_inspection_form_code' => 'tipo_aceite',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'Verficación de filtro de aceite',
                                'ct_inspection_form_code' => 'verificacion_filtro_aceite',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'Nivel de Aceite',
                                'ct_inspection_form_code' => 'nivel_aceite',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'Inspección Visual de Aceite',
                                'ct_inspection_form_code' => 'inspeccion_visual_aceite',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'Análisis de Aceite',
                                'ct_inspection_form_code' => 'analisis_aceite',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'Funcionamiento Filtro On-Line',
                                'ct_inspection_form_code' => 'funcionamiento_filtro_on_line',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'Funcionamiento Filtrado Off-Line',
                                'ct_inspection_form_code' => 'funcionamiente_filtro_off_line',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'Fugas Sistema Filtrado Off-Line',
                                'ct_inspection_form_code' => 'fugas_sistema_filtrado_off_line',
                            ],
                        ],
                    ],
                    // END SUB SECTION: SISTEMA DE LUBRICACIÓN
                    // SUB SECTION: OTROS COMPONENTES
                    [
                        'ct_inspection_section_uuid' => Str::uuid()->toString(),
                        'ct_inspection_section' => 'Otros componentes',
                        'ct_inspection_section_code' => 'otros_componentes',
                        'ct_inspection_id' => $multiplicator,
                        'fields' => [
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'Sistema Amortiguadores',
                                'ct_inspection_form_code' => 'sistema_amortiguadores',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'Juntas',
                                'ct_inspection_form_code' => 'juntas',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'Sensores Temperatura',
                                'ct_inspection_form_code' => 'sensores_temperatura',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'Sensores de Vibraciones',
                                'ct_inspection_form_code' => 'sensores_vibraciones',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'Virutas Imán Multiplicadora',
                                'ct_inspection_form_code' => 'virutas_iman_multiplicadora',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'Virutas Dentro De Multiplicadora',
                                'ct_inspection_form_code' => 'virutas_dentro_multiplicadora',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'Fuga Tapa Uniones y/o Tapa Multiplicadora',
                                'ct_inspection_form_code' => 'fuga_tapa_uniones_multiplicadora',
                            ],
                        ],
                    ],
                    // END SUB SECTION: OTROS COMPONENTES
                ],
            ],
            // END SECTION INTERNAL
            // SECTION INTERNAL
            [
                'ct_inspection_section_uuid' => Str::uuid()->toString(),
                'ct_inspection_section' => 'Inspección Interna',
                'ct_inspection_section_code' => 'inspeccion_interna',
                'ct_inspection_id' => $multiplicator,
                'sub_sections' => [
                    // SUB SECTION: INSPECCIÓN ENGRANAJES
                    [
                        'ct_inspection_section_uuid' => Str::uuid()->toString(),
                        'ct_inspection_section' => 'Inspección Engranajes',
                        'ct_inspection_section_code' => 'inspeccion_engranajes',
                        'ct_inspection_id' => $multiplicator,
                        'fields' => [
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'IMSS-LSS',
                                'ct_inspection_form_code' => 'imss_lss',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'IMSS-HSS',
                                'ct_inspection_form_code' => 'imss_hss',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'LSS',
                                'ct_inspection_form_code' => 'lss',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'RING',
                                'ct_inspection_form_code' => 'ring',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'SUN',
                                'ct_inspection_form_code' => 'sun',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'SAT 1',
                                'ct_inspection_form_code' => 'sat_1',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'SAT 2',
                                'ct_inspection_form_code' => 'sat_2',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'SAT 3',
                                'ct_inspection_form_code' => 'sat_3',
                            ],
                        ],
                    ],
                    // END SUB SECTION: INSPECCIÓN ENGRANAJES
                    // SUB SECTION: INSPECCIÓN RODAMIENTOS
                    [
                        'ct_inspection_section_uuid' => Str::uuid()->toString(),
                        'ct_inspection_section' => 'Inspección de Rodamientos',
                        'ct_inspection_section_code' => 'inspeccion_rodamientos',
                        'ct_inspection_id' => $multiplicator,
                        'fields' => [
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'HSS GEN',
                                'ct_inspection_form_code' => 'hss_gen',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'HSS ROT',
                                'ct_inspection_form_code' => 'hss_rot',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'IMS GEN',
                                'ct_inspection_form_code' => 'ims_gen',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'IMS ROT',
                                'ct_inspection_form_code' => 'ims_rot',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'LSS ROT',
                                'ct_inspection_form_code' => 'lss_rot',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'LSS GEN',
                                'ct_inspection_form_code' => 'lss_gen',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'PC ROT',
                                'ct_inspection_form_code' => 'pc_rot',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'PC GEN',
                                'ct_inspection_form_code' => 'pc_gen',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'SAT A',
                                'ct_inspection_form_code' => 'sat_a',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'SAT B',
                                'ct_inspection_form_code' => 'sat_b',
                            ],
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'SAT C',
                                'ct_inspection_form_code' => 'sat_c',
                            ],
                        ],
                    ],
                    // END SUB SECTION: INSPECCIÓN RODAMIENTOS
                    // SUB SECTION: INSPECCIÓN CARCASAS
                    [
                        'ct_inspection_section_uuid' => Str::uuid()->toString(),
                        'ct_inspection_section' => 'Inspección de Carcasas',
                        'ct_inspection_section_code' => 'inspeccion_carcasas',
                        'ct_inspection_id' => $multiplicator,
                        'fields' => [
                            [
                                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                                'ct_inspection_form' => 'Inspección de Carcasas',
                                'ct_inspection_form_code' => 'inspeccion_carcasas',
                            ],
                        ],
                    ],
                    // END SUB SECTION: INSPECCIÓN CARCASAS
                ],
            ],
        ];
    }
}
