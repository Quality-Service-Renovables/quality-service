<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Inspections\Categories;

use App\Models\Inspections\Categories\CtInspection;
use App\Models\Inspections\Categories\CtInspectionSection;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class CtInspectionSectionService extends Service
{
    public string $nameService = 'ct_inspection_section';

    public object $inspection;

    /**
     * Create a new category.
     *
     * @param \Illuminate\Http\Request $request The request object.
     *
     * @return array The response containing the created category.
     */
    public function create(Request $request): array
    {
        try {
            // Control Transaction
            DB::beginTransaction();
            $category = CtInspection::where('ct_inspection_uuid', $request->ct_inspection_uuid)->first();
            // Si es una sub sección se obtiene el identificador de la sección.
            if ($request->ct_inspection_relation_uuid) {
                $relation = CtInspectionSection::where('ct_inspection_section_uuid',
                    $request->ct_inspection_relation_uuid)->first();
                $request->merge([
                    'ct_inspection_relation_id' => $relation->ct_inspection_section_id,
                ]);
            }
            // Establecer atributos para registro
            $request->merge([
                'ct_inspection_section_uuid' => Str::uuid()->toString(),
                'ct_inspection_section_code' => create_slug($request->ct_inspection_section),
                'ct_inspection_id' => $category->ct_inspection_id,
            ]);
            // Set Response
            $this->statusCode = 201;
            $this->response['message'] = trans('api.created');
            $this->response['data'] = CtInspectionSection::create($request->except(['ct_inspection_relation_uuid']));
            // Set Log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                'Create new section',
                $request->user()->id,
            );
            // Commit Transaction
            DB::commit();
        } catch (Throwable $exceptions) {
            DB::rollBack();
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Response
        return $this->response;
    }

    /**
     * Retrieve the list of categories.
     *
     * @return array The response containing the list of categories.
     *
     * @throws \Exception If there is an error retrieving the list of categories.
     */
    public function read(): array
    {
        try {
            // Obtiene las secciones de inspección y su correspondiente categoría
            $sections = CtInspectionSection::with(['category'])
                ->whereNull('ct_inspection_relation_id')->get();
            // Obtiene las sub secciones
            foreach ($sections as $section) {
                $section->sub_sections = CtInspectionSection::where([
                    'ct_inspection_relation_id' => $section->ct_inspection_section_id,
                ])->get();
            }
            $this->response['message'] = trans('api.read');
            $this->response['data'] = $sections;
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        return $this->response;
    }

    /**
     * Update a category.
     *
     * @param \Illuminate\Http\Request $request The request data.
     *
     * @return array The response containing the updated category.
     *
     * @throws \Exception If there is an error updating the category.
     */
    public function update(Request $request): array
    {
        try {
            // Control Transaction
            DB::beginTransaction();
            $category = CtInspection::where('ct_inspection_uuid', $request->ct_inspection_uuid)->first();
            // Si es una sub sección se obtiene el identificador de la sección.
            if ($request->ct_inspection_relation_uuid) {
                $relation = CtInspectionSection::where('ct_inspection_section_uuid',
                    $request->ct_inspection_relation_uuid)->first();
                $request->merge([
                    'ct_inspection_relation_id' => $relation->ct_inspection_section_id,
                ]);
            }
            // Establecer atributos para registro
            $request->merge([
                'ct_inspection_section_code' => create_slug($request->ct_inspection_section),
                'ct_inspection_id' => $category->ct_inspection_id,
            ]);

            $section = CtInspectionSection::where([
                'ct_inspection_section_uuid' => $request->ct_inspection_section_uuid,
            ])->first();

            $section->update($request->except([
                'ct_inspection_relation_uuid', 'ct_inspection_uuid',
            ]));

            $this->response['message'] = trans('api.updated');
            $this->response['data'] = $section;
            // Set Log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                'Create new section',
                $request->user()->id,
            );
            // Commit Transaction
            DB::commit();
        } catch (Throwable $exceptions) {
            DB::rollBack();
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Response
        return $this->response;
    }

    /**
     * Delete a category by UUID.
     *
     * @param string $uuid The UUID of the category to delete.
     *
     * @return array The response indicating the result of the deletion.
     *
     * @throws \Exception If there is an error deleting the category.
     */
    public function delete(string $uuid): array
    {
        try {
            // Control Transaction
            DB::beginTransaction();
            // Delete Register
            $section = CtInspectionSection::where('ct_inspection_section_uuid', $uuid)
                ->first();
            // Elimina sub secciones para evitar secciones huérfanas
            if (!$section->ct_inspection_relation_id) {
                $subSections = CtInspectionSection::where([
                    'ct_inspection_relation_id' => $section->ct_inspection_section_id,
                ])->get();
                foreach ($subSections as $subSection) {
                    $subSection->delete();
                }
            }
            // Elimina sección
            $section?->delete();
            // Set Response
            $this->response['message'] = trans('api.deleted');
            // Commit Transaction
            DB::commit();
        } catch (Throwable $exceptions) {
            DB::rollBack();
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Response
        return $this->response;
    }

    /**
     * Retrieve a specific category.
     *
     * @param string $uuid The UUID of the category to retrieve.
     *
     * @return array The response containing the category.
     *
     * @throws \Exception If there is an error retrieving the category.
     */
    public function show(string $uuid): array
    {
        try {
            // Obtiene las secciones de inspección y su correspondiente categoría
            $section = CtInspectionSection::with(['category'])
                ->whereNull('ct_inspection_relation_id')
                ->where('ct_inspection_section_uuid', '=', $uuid)
                ->first();
            // Obtiene las sub secciones
            if ($section) {
                $section->sub_sections = CtInspectionSection::where([
                    'ct_inspection_relation_id' => $section->ct_inspection_section_id,
                ])->get();
            }
            // Respuesta del módulo
            $this->response['message'] = trans('api.read');
            $this->response['data'] = $section;
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        return $this->response;
    }
}
