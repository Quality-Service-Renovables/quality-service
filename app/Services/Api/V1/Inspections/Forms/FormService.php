<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Inspections\Forms;

use App\Models\Inspections\FormInspection;
use App\Models\Inspections\Categories\FormInspection as CtFormInspection;
use App\Models\Inspections\Categories\Section;
use App\Models\Inspections\Category;
use App\Models\Inspections\CategoryForm;
use App\Models\Inspections\Inspection;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class FormService extends Service
{
    public string $nameService = 'ct_inspection';

    /**
     * Sets the form for a given request.
     *
     * @param  Request  $request  The HTTP request object.
     * @return array The response array.
     */
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
                // Define la sección raíz
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
        $createdSection = Section::create([
            'ct_inspection_section_uuid' => Str::uuid()->toString(),
            'ct_inspection_section' => $section['ct_inspection_section'],
            'ct_inspection_section_code' => create_slug($section['ct_inspection_section']),
            'ct_inspection_id' => $ctInspectionId,
            'ct_inspection_relation_id' => $sectionRelationId,
        ]);

        return $createdSection->ct_inspection_section_id;
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
                        ->with("formInspection")->get();
                    if ($fields) {
                        $form = $this->buildForm($sections, $fields);
                    }
                }
            }
            // Response
            $this->response['message'] = trans('api.read');
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
                // Set section details
                $form['sections'][$sectionCode]['section_details'] = $currentSection;
                // Set fields
                $form['sections'][$sectionCode]['fields'] = $fields->where('ct_inspection_section_id', $section->ct_inspection_relation_id);
                $section['fields'] = $fields->collect()->mapWithKeys(function ($item) {
                    return [$item['ct_inspection_form_code'] => $item];
                })->where('ct_inspection_section_id', $section->ct_inspection_section_id)->all();
                // Set sub section
                $form['sections'][$sectionCode]['sub_sections'][] = $section;
            } else {
                // Tratamiento exclusivo para secciones principales o raíces
                $form['sections'][$section->ct_inspection_section_code]['section_details'] = $section;
                $form['sections'][$section->ct_inspection_section_code]['fields'] = $fields->where('ct_inspection_section_id', $section->ct_inspection_section_id);
                $section['fields'] = $fields->collect()->mapWithKeys(function ($item) {
                    return [$item['ct_inspection_form_code'] => $item];
                })->where('ct_inspection_section_id', $section->ct_inspection_section_id)->all();
            }
        }

        return $form;
    }

    /**
     * Sets the form inspection.
     *
     * @param Request $request The request object.
     *
     * @return array The response data.
     */
    public function setFormInspection(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            $inspection = Inspection::where('inspection_uuid', $request->inspection_uuid)->first();
            $categoryForm = CtFormInspection::all();
            $inspectionForms = [];
            foreach ($request->form as $formInspection) {
                $categoryFormId = $categoryForm->where(
                    'ct_inspection_form_uuid', '=', $formInspection['ct_inspection_form_uuid'])
                    ->first()->ct_inspection_form_id;

                $formInspection['inspection_form_uuid'] = Str::uuid()->toString();
                $formInspection['inspection_id'] = $inspection->inspection_id;
                $formInspection['ct_inspection_form_id'] = $categoryFormId;

                $inspectionForms[] = FormInspection::create($formInspection);
            }

            $this->statusCode = 201;
            $this->response['message'] = trans('api.created');
            $this->response['data'] = $inspectionForms;
            // Registro en log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                trans('api.message_log'),
            );
            // Finaliza Transacción
            DB::commit();
        } catch (Throwable $exceptions) {
            DB::rollBack();
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Sets the form fields for a given inspection form.
     *
     * @param  Request  $request  The request object containing the form data.
     * @return array The response data.
     */
    public function setFormFields(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Campos a registrar
            $fields = [];
            // Obtiene la sección a la cuál se asociará el campo
            $section = Section::where([
                'ct_inspection_section_uuid' => $request->ct_inspection_section_uuid,
            ])->first();
            // Si la sección existe se registran los campos
            if ($section) {
                // Registro de campos
                foreach ($request->fields as $field) {
                    // Adjunta dependencias del campo para el registro
                    $field['ct_inspection_form_uuid'] = Str::uuid()->toString();
                    $field['ct_inspection_form_code'] = create_slug($field['ct_inspection_form']);
                    $field['ct_inspection_section_id'] = $section->ct_inspection_section_id;
                    // Registro de campos
                    $fields[] = FormInspection::create($field);
                }
            }

            $this->statusCode = 201;
            $this->response['message'] = trans('api.created');
            $this->response['data'] = $fields;
            // Registro en log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                trans('api.message_log'),
            );
            // Finaliza Transacción
            DB::commit();
        } catch (Throwable $exceptions) {
            DB::rollBack();
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Update a form field.
     *
     * @param \Illuminate\Http\Request $request The HTTP request
     *
     * @return array The response data
     */
    public function updateFormField(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Campos a registrar
            $field = null;
            // Obtiene la sección a la cuál se asociará el campo
            $section = Section::where([
                'ct_inspection_section_uuid' => $request->ct_inspection_section_uuid,
            ])->first();
            // Si la sección existe se registran los campos
            if ($section) {
                // Adjunta dependencias del campo para el registro
                $request->merge([
                    'ct_inspection_form_code' => create_slug($request->ct_inspection_form),
                    'ct_inspection_section_id' => $section->ct_inspection_section_id,
                ]);
                // Registro de campos
                $field = FormInspection::where([
                    'ct_inspection_form_uuid' => $request->ct_inspection_form_uuid,
                ])->update($request->except([
                    'ct_inspection_section_uuid',
                ]));
            }

            $this->response['message'] = trans('api.updated');
            $this->response['data'] = $field;
            // Registro en log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                trans('api.message_log'),
            );
            // Finaliza Transacción
            DB::commit();
        } catch (Throwable $exceptions) {
            DB::rollBack();
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Deletes a form field by UUID.
     *
     * @param  string  $uuid  The UUID of the form field to be deleted.
     * @return array The response array containing the status code, message, and data.
     */
    public function deleteFormField(string $uuid): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Elimina por soft delete el campo de la sección
            $formInspection = FormInspection::where([
                'ct_inspection_form_uuid' => $uuid,
            ])->first();
            // Se existe el campo se elimina
            $formInspection?->delete();
            // Respuesta de la api
            $this->statusCode = $formInspection ? 204 : 404;
            $this->response['message'] = trans('api.deleted');
            $this->response['data'] = [];
            // Finaliza Transacción
            DB::commit();
        } catch (Throwable $exceptions) {
            DB::rollBack();
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }
}
