<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Inspections\Forms;

use App\Models\Inspections\Categories\Section;
use App\Models\Inspections\Category;
use App\Models\Inspections\CategoryForm;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class FormService extends Service
{
    public string $nameService = 'ct_inspection';

    public function setForm(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // En este punto ha sido validada la existencia de la categoría de inspección
            $inspectionCategory = Category::where([
                'ct_inspection_code' => $request->ct_inspection_code,
            ])->first();

            $ctInspectionId = $inspectionCategory->ct_inspection_id;
            // Itera sobre las secciones para la construcción del formulario
            foreach ($request->sections as $section) {
                // Definie la sección raíz
                $inspectionSectionId = $this->setSection($section, $ctInspectionId);
                // En caso de que existan campos asociados a la sección raíz se registran
                if ($section['fields'] && count($section['fields'])) {
                    $this->setSectionFields($section['fields'], $inspectionSectionId);
                }
                // Si existen sub secciones se registran
                if ($section['sub_sections'] && count($section['sub_sections'])) {
                    $this->setSubSection($section['sub_sections'], $ctInspectionId, $inspectionSectionId);
                }
            }
            // Recupera relación de registros
            $this->getForm($inspectionCategory->ct_inspection_uuid);
            // Response
            $this->response['message'] = trans('api.created');
            // Finaliza Transacción
            DB::commit();
        } catch (Throwable $exceptions) {
            DB::rollBack();
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        return $this->response;
    }

    /**
     * Sets the sub-sections for a given section.
     *
     * @param  array  $subSections  The array of sub-sections.
     * @param  int  $ctInspectionId  The inspection category ID.
     * @param  int  $sectionRelationId  The ID of the parent section.
     */
    private function setSubSection(array $subSections, int $ctInspectionId, int $sectionRelationId): void
    {
        foreach ($subSections as $subSection) {
            $newSubSection = $this->setSection($subSection, $ctInspectionId, $sectionRelationId);
            if ($subSection['fields']) {
                $this->setSectionFields($subSection['fields'], $newSubSection);
            }
        }
    }

    /**
     * Create a new inspection section.
     *
     * @param  array  $section  The section data.
     * @param  int  $ctInspectionId  The ID of the inspection.
     * @param  int|null  $sectionRelationId  The ID of the parent section relation (optional).
     * @return int The ID of the created section.
     */
    private function setSection(array $section, int $ctInspectionId, ?int $sectionRelationId = null): int
    {
        $section = Section::create([
            'ct_inspection_section_uuid' => Str::uuid()->toString(),
            'ct_inspection_section' => $section['ct_inspection_section'],
            'ct_inspection_section_code' => create_slug($section['ct_inspection_section']),
            'ct_inspection_id' => $ctInspectionId,
            'ct_inspection_relation_id' => $sectionRelationId,
        ]);

        return $section->ct_inspection_section_id;
    }

    /**
     * Sets the section fields for a given inspection section.
     *
     * @param  array  $fields  The array of fields to be created.
     * @param  int  $inspectionSectionId  The ID of the inspection section.
     */
    private function setSectionFields(array $fields, int $inspectionSectionId): void
    {
        foreach ($fields as $field) {
            CategoryForm::create([
                'ct_inspection_form_uuid' => Str::uuid()->toString(),
                'ct_inspection_form' => $field['ct_inspection_form'],
                'ct_inspection_form_code' => create_slug($field['ct_inspection_form']),
                'ct_inspection_section_id' => $inspectionSectionId,
                'required' => $field['required'],
            ]);
        }
    }

    /**
     * Retrieves the form for a given inspection category UUID.
     *
     * @param  string  $uuid  The UUID of the inspection category.
     * @return array The form data.
     */
    public function getForm(string $uuid): array
    {
        try {
            $form = [];
            $inspectionCategory = Category::where([
                'ct_inspection_uuid' => $uuid,
            ])->first();

            if ($inspectionCategory) {
                $sections = Section::where([
                    'ct_inspection_id' => $inspectionCategory->ct_inspection_id,
                ])->get();

                if (count($sections)) {
                    $fields = CategoryForm::whereIn(
                        'ct_inspection_section_id', $sections->pluck('ct_inspection_section_id'))
                        ->get();
                    if ($fields) {
                        $form = $this->buildForm($sections, $fields);
                    }
                }
            }
            // Response
            $this->response['message'] = trans('api.readed');
            $this->response['data'] = $form;
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        return $this->response;
    }

    /**
     * Builds the form based on sections and fields.
     *
     * @param  \Illuminate\Support\Collection  $sections  The collection of sections.
     * @param  \Illuminate\Support\Collection  $fields  The collection of fields.
     * @return array The built form.
     */
    private function buildForm(Collection $sections, Collection $fields): array
    {
        $form['sections'] = [];
        // Iteración sobre raíces encontradas
        foreach ($sections as $section) {
            // Tratamiento para sub secciones y creación de secciones dinámica
            if ($section->ct_inspection_relation_id) {
                $currentSection = $section->where('ct_inspection_section_id', '=', $section->ct_inspection_relation_id)->first();
                $sectionCode = $currentSection->ct_inspection_section_code;
                // Set fields
                $form['sections'][$sectionCode]['fields'] = $fields->where('ct_inspection_section_id', $section->ct_inspection_relation_id);
                $section['fields'] = $fields->collect($section['fields'])->mapWithKeys(function ($item) {
                    return [$item['ct_inspection_form_code'] => $item];
                })->where('ct_inspection_section_id', $section->ct_inspection_section_id)->all();
                // Set sub section
                $form['sections'][$sectionCode]['sub_sections'][] = $section;
            } else {
                // Tratamiento exclusivo para secciones principales o raices
                $form['sections'][$section->ct_inspection_section_code]['fields'] = $fields->where('ct_inspection_section_id', $section->ct_inspection_section_id);
                $section['fields'] = $fields->collect($section['fields'])->mapWithKeys(function ($item) {
                    return [$item['ct_inspection_form_code'] => $item];
                })->where('ct_inspection_section_id', $section->ct_inspection_section_id)->all();
            }
        }

        return $form;
    }
}