<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Inspections;

use Throwable;
use App\Services\Service;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Inspections\Evidence;
use App\Models\Inspections\Inspection;
use App\Models\Inspections\InspectionForm;
use App\Models\Inspections\Categories\CtInspection;
use App\Services\Api\V1\Inspections\EvidenceService;
use App\Models\Inspections\Categories\CtInspectionForm;
use App\Models\Inspections\Categories\CtInspectionSection;

class InspectionFormService extends Service
{
    public string $nameService = 'ct_inspection';

    /**
     * Sets the form for a given request.
     *
     * @param Request $request The HTTP request object.
     *
     * @return array The response array.
     */
    public function setForm(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // En este punto ha sido validada la existencia de la categoría de inspección
            $inspectionCategory = CtInspection::where([
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
     * @param array $subSections       The array of sub-sections.
     * @param int   $ctInspectionId    The inspection category ID.
     * @param int   $sectionRelationId The ID of the parent section.
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
     * @param array    $section           The section data.
     * @param int      $ctInspectionId    The ID of the inspection.
     * @param int|null $sectionRelationId The ID of the parent section relation (optional).
     *
     * @return int The ID of the created section.
     */
    private function setSection(array $section, int $ctInspectionId, ?int $sectionRelationId = null): int
    {
        $createdSection = CtInspectionSection::create([
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
     * @param array $fields              The array of fields to be created.
     * @param int   $inspectionSectionId The ID of the inspection section.
     */
    private function setSectionFields(array $fields, int $inspectionSectionId): void
    {
        foreach ($fields as $field) {
            CtInspectionForm::create([
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
     * @param string $uuid The UUID of the inspection category.
     *
     * @return array The form data.
     */
    public function getForm(string $uuid): array
    {
        try {
            $form = [];
            $inspectionCategory = CtInspection::where([
                'ct_inspection_uuid' => $uuid,
            ])->first();
            if ($inspectionCategory) {
                $sections = CtInspectionSection::where([
                    'ct_inspection_id' => $inspectionCategory->ct_inspection_id,
                ])->get();

                if (count($sections)) {
                    $fields = CtInspectionForm::whereIn(
                        'ct_inspection_section_id', $sections->pluck('ct_inspection_section_id'))
                        ->with(["result.risk", "result.evidences"])->get();
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
     * Retrieves the form for a given inspection category UUID, related to an inspection.
     *
     * @param string $uuid The UUID of the inspection.
     *
     * @return array The form data.
     */
    public function getFormInspection(string $uuid): array
    {
        try {
            $form = [];
            $inspection = Inspection::where('inspection_uuid', $uuid)->first();

            if ($inspection) {
                $sections = CtInspectionSection::where([
                    'ct_inspection_id' => $inspection->ct_inspection_id,
                ])->get();

                if (count($sections)) {
                    $fields = CtInspectionForm::whereIn(
                        'ct_inspection_section_id', $sections->pluck('ct_inspection_section_id'))
                        ->get();
                    if ($fields) {
                        foreach ($fields as $key => $field) {
                            $fields[$key]->content = InspectionForm::where([
                                'ct_inspection_form_id' => $field->ct_inspection_form_id,
                                'inspection_id' => $inspection->inspection_id,
                            ])->with("evidences")->first();
                        }
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
     * Retrieves evidences of a form related to an inspection.
     *
     * @param string $uuid The ID of the inspection form.
     *
     * @return array The form data.
     */
    public function getFormEvidences(string $id): array{
        try {
            $evidences = Evidence::where('inspection_form_id', $id)->get();
            $this->response['message'] = trans('api.read');
            $this->response['data'] = $evidences;
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }
        return $this->response;
    }

    /**
     * Builds the form based on sections and fields.
     *
     * @param \Illuminate\Support\Collection $sections The collection of sections.
     * @param \Illuminate\Support\Collection $fields   The collection of fields.
     *
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
                //$form['sections'][$sectionCode]['fields'] = $fields->where('ct_inspection_section_id', $section->ct_inspection_relation_id);
                $form['sections'][$sectionCode]['fields'] = $fields->where('ct_inspection_section_id', $section->ct_inspection_relation_id)->mapWithKeys(function ($item) {
                    return [$item['ct_inspection_form_code'] => $item];
                })->all(); 
                $section['fields'] = $fields->collect()->mapWithKeys(function ($item) {
                    return [$item['ct_inspection_form_code'] => $item];
                })->where('ct_inspection_section_id', $section->ct_inspection_section_id)->all();
                // Set sub section
                $form['sections'][$sectionCode]['sub_sections'][] = $section;
            } else {
                // Tratamiento exclusivo para secciones principales o raíces
                $form['sections'][$section->ct_inspection_section_code]['section_details'] = $section;
                //$form['sections'][$section->ct_inspection_section_code]['fields'] = $fields->where('ct_inspection_section_id', $section->ct_inspection_section_id);
                $form['sections'][$section->ct_inspection_section_code]['fields'] = $fields->where('ct_inspection_section_id', $section->ct_inspection_section_id)
                    ->mapWithKeys(function ($item) {
                        return [$item['ct_inspection_form_code'] => $item];
                    })->all(); 
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
            // Guarda el contenido completo del request en el archivo de log
            Log::info('Contenido del Request:', $request->all());

            // Si deseas registrar un mensaje adicional con el log
            Log::info('Request recibido y procesado correctamente.');

            // Control de transacciones
            DB::beginTransaction();
            $inspection = Inspection::where('inspection_uuid', $request->inspection_uuid)->first();
            $categoryForm = CtInspectionForm::all();
            $inspectionForms = [];
            foreach ($request->form as $formInspection) {
                $categoryFormId = $categoryForm->where(
                    'ct_inspection_form_uuid', '=', $formInspection['ct_inspection_form_uuid'])
                    ->first()->ct_inspection_form_id;

                $inspectionFormUuid = InspectionForm::where([
                    'inspection_id' => $inspection->inspection_id,
                    'ct_inspection_form_id' => $categoryFormId,
                ])->first()->inspection_form_uuid ?? Str::uuid()->toString();

                $inspectionForm = InspectionForm::updateOrCreate([
                    'inspection_id' => $inspection->inspection_id,
                    'ct_inspection_form_id' => $categoryFormId,
                ], [
                    'inspection_form_uuid' => $inspectionFormUuid,
                    'inspection_form_comments' => $formInspection['inspection_form_comments'],
                    'inspection_form_value' => $formInspection['inspection_form_value'] ?? '',
                    'ct_risk_id' => $formInspection['ct_risk_id'] ?? null,
                ]);

                $inspectionForm->load('field');

                $inspectionForms[] = $inspectionForm;
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
     * @param Request $request The request object containing the form data.
     *
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
            $section = CtInspectionSection::where([
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
                    $fields[] = CtInspectionForm::create($field);
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
            $section = CtInspectionSection::where([
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
                $field = CtInspectionForm::where([
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
     * @param string $uuid The UUID of the form field to be deleted.
     *
     * @return array The response array containing the status code, message, and data.
     */
    public function deleteFormField(string $uuid): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Elimina por soft delete el campo de la sección
            $formInspection = CtInspectionForm::where([
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

    public function getFieldSuggestions(string $uuid)
    {
        try {
            $categoryForm = CtInspectionForm::where([
                'ct_inspection_form_uuid' => $uuid,
            ])->first();
            $inspectionForms = InspectionForm::where([
                'ct_inspection_form_id' => $categoryForm->ct_inspection_form_id,
            ])->whereNotNull("inspection_form_comments")->get();
            $this->response['message'] = trans('api.read');
            $this->response['data'] = $inspectionForms->pluck('inspection_form_comments');
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }
        // Respuesta del módulo
        return $this->response;
    }
}
