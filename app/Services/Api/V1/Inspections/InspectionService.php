<?php

/** @noinspection PhpPossiblePolymorphicInvocationInspection */

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Inspections;

use App\Models\Clients\Client;
use App\Models\Equipments\Equipment;
use App\Models\Inspections\Categories\CtInspection;
use App\Models\Inspections\Inspection;
use App\Models\Projects\Project;
use App\Models\Status\Status;
use App\Services\Api\Audits;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class InspectionService extends Service
{
    use Audits;

    public string $nameService = 'inspection';

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
            $category = CtInspection::where('ct_inspection_code', $request->ct_inspection_code)->first();
            $equipment = Equipment::where('equipment_uuid', $request->equipment_uuid)->first();
            $project = Project::where('project_uuid', '=', $request->project_uuid)->first();
            $status = Status::with(['category'])
                ->where('status_code', '=', 'proyecto_iniciado')
                ->first();

            if (($status && $status->category) && $status->category->ct_status_code === 'proyecto') {
                // Establecer atributos para registro
                $request->merge([
                    'inspection_uuid' => Str::uuid()->toString(),
                    'ct_inspection_id' => $category->ct_inspection_id,
                    'equipment_id' => $equipment->equipment_id,
                    'client_id' => Client::where('client_uuid', '=', $request->client_uuid)
                        ->first()->client_id,
                    'status_id' => $status->status_id,
                    'project_id' => $project->project_id,
                ]);
                // Create Register
                $inspection = Inspection::create($request->all());
                $project->status_id = $status->status_id;
                $project->save();
                // Set Response
                $this->statusCode = 201;
                $this->response['message'] = trans('api.created');
                $this->response['data'] = $inspection;
                // Set Log
                $this->logService->create(
                    $this->nameService,
                    $request->all(),
                    $this->response,
                    trans('api.message_log'),
                    $request->user()->id,
                );
                // Crear log de auditoria
                $this->proyectAudits(
                    $project->project_id,
                    $project->status_id,
                    $this->logService->log->application_log_id,
                    trans('api.status_project_started')
                );
                // Commit Transaction
                DB::commit();
            } else {
                // En caso de que el estado no sea válido se retorna el error
                $this->statusCode = 422;
                $this->response['status'] = 'fail';
                $this->response['errors'] = [
                    'status_expected' => trans('api.status_inspection'),
                ];
                $this->response['message'] = trans('api.status_invalid');
            }
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
            $this->response['message'] = trans('api.read');
            $this->response['data'] = ['inspections' => Inspection::with([
                'client',
                'equipment.model.trademark',
                'inspectionEquipments.equipment',
                'category.sections.subSections.fields.result',
                'evidences' => function ($query) {
                    $query->orderBy('position');
                },
                'status.category',
                'project',
            ])->get()];
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
            $category = CtInspection::where('ct_inspection_code', $request->ct_inspection_code)->first();
            $equipment = Equipment::where('equipment_uuid', $request->equipment_uuid)->first();
            $project = Project::where('project_uuid', '=', $request->project_uuid)->first();

            if ($project) {
                // Control Transaction
                DB::beginTransaction();
                // Establecer atributos para registro
                $request->merge([
                    'ct_inspection_id' => $category->ct_inspection_id,
                    'equipment_id' => $equipment->equipment_id,
                    'client_id' => Client::where('client_uuid', '=', $request->client_uuid)
                        ->first()->client_id,
                    'project_id' => $project->project_id,
                ]);
                // Update Register
                $category = Inspection::where('inspection_uuid', $request->inspection_uuid)->first();
                // Si el $category existe (no es nulo), actualízalo con todos los datos de la solicitud.
                $category?->update($request->except([
                    'client_uuid', 'status_code', 'project_uuid',
                ]));
                // Set Response
                $this->response['message'] = trans('api.updated');
                $this->response['data'] = $category;
                // Set Log
                $this->logService->create(
                    $this->nameService,
                    $request->all(),
                    $this->response,
                    'Update new inspection',
                    $request->user()->id,
                );
                // Commit Transaction
                DB::commit();
            }
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
            Inspection::where('inspection_uuid', $uuid)
                ->update([
                    'deleted_at' => now(),
                ]);
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
            $user = auth()->user()->load('client');
            $inspection = Inspection::with([
                'client',
                'equipment.model.trademark',
                'inspectionEquipments.equipment',
                'category.sections.subSections.fields.result',
                'evidences',
                'status.category',
                'project',
            ])->where('inspection_uuid', $uuid)->first();

            if ($inspection) {
                $inspection->provider = $user->client;
            }

            $this->response['message'] = trans('api.show');
            $this->response['data'] = $inspection;
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        return $this->response;
    }
}
