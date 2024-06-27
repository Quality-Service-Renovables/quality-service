<?php
/**
 * Equipment Service.
 *
 * Register equipments
 *
 * @author   Luis Adrian Olvera Facio
 *
 * @version  1.0
 *
 * @since    2024.1
 */

/** @noinspection NullPointerExceptionInspection */

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Projects;

use App\Models\Clients\Client;
use App\Models\Projects\Project;
use App\Models\Status\Status;
use App\Services\Api\Audits;
use App\Services\Api\ServiceInterface;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class ProjectService extends Service implements ServiceInterface
{
    use Audits;
    public string $nameService = 'project_service';

    /**
     * Create a new equipment
     *
     * @param  Request  $request  The request object
     * @return array Returns an array containing the created equipment data
     */
    public function create(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Agrega atributos a la solicitud
            $request->merge([
                'project_uuid' => Str::uuid()->toString(),
                'status_id' => Status::where('status_code',
                    '=',
                    'proyecto_creado')
                    ->first()->status_id,
                'client_id' => Client::where('client_uuid',
                    '=',
                    $request->client_uuid
                )->first()->client_id,
            ]);
            $project = Project::create($request->all());
            // Registro en log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                trans('api.message_log'),
            );
            // Crear log de auditoria
            $this->proyectAudits(
                $project->project_id,
                $project->status_id,
                $this->logService->log->application_log_id,
                trans('api.status_project_created')
            );
            // Registra los atributos de la solicitud
            $this->statusCode = 201;
            $this->response['message'] = trans('api.created');
            $this->response['data'] = $project;
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
     * Retrieve all equipment data
     *
     * @return array Returns an array containing the equipment data
     */
    public function read(): array
    {
        $this->response['message'] = trans('api.read');
        $this->response['data'] = Project::with([
            'client',
            'status',
            'employees.user',
            'inspections.status',
            'inspections.category',
            'inspections.equipment.category',
            'inspections.inspectionEquipments.equipment'
        ])->get();

        return $this->response;
    }

    /**
     * Update equipment data
     *
     * @param  Request  $request  The request object containing the updated data
     * @return array Returns an array containing the updated equipment data
     */
    public function update(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Obtiene estado
            $status = Status::with(['category'])
                ->where('status_uuid',
                    '=',
                    $request->status_uuid)
                ->first();
            $clientId = Client::where('client_uuid',
                '=',
                $request->client_uuid
            )->first()->client_id;
            // Si el estado es correspondiente a proyectos
            if (($status && $status->category) && $status->category->ct_status_code === 'proyecto') {
                // Si el proyecto ha sido cancelado y no se proporcionan comentarios, no es posible proceder.
                if ($status->status_code === 'proyecto_cancelado' && $request->comments === '') {
                    $this->statusCode = 422;
                    $this->response['message'] = trans('api.comments_required');
                } else {
                    // Agrega atributos a la solicitud
                    $request->merge([
                        'status_id' => $status->status_id,
                        'client_id' => $clientId,
                    ]);
                    // Actualiza Equipo
                    $project = Project::with(['inspections'])
                        ->where('project_uuid', $request->project_uuid)->first();
                    $project?->update($request->except([
                        'status_uuid', 'client_uuid',
                    ]));

                    foreach ($project->inspections as $inspection) {
                        $inspection->client_id = $clientId;
                        $inspection->status_id = $status->status_id;
                        $inspection->save();
                    }

                    $this->response['message'] = trans('api.updated');
                    $this->response['data'] = $project;
                    // Registro de log
                    $this->logService->create(
                        $this->nameService,
                        $request->all(),
                        $this->response,
                        trans('api.message_log'),
                    );
                    // Crear log de auditoria
                    $this->proyectAudits(
                        $project->project_id,
                        $project->status_id,
                        $this->logService->log->application_log_id,
                        trans('api.updated')
                    );
                    // Confirmación de transacción
                    DB::commit();
                }
            } else {
                // En caso de que el estado no sea válido se retorna el error
                $this->statusCode = 422;
                $this->response['status'] = 'fail';
                $this->response['errors'] = [
                    'status_expected' => trans('api.status_projects'),
                ];
                $this->response['message'] = trans('api.status_invalid');
            }
        } catch (Throwable $exceptions) {
            DB::rollBack();
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Delete equipment by UUID.
     *
     * @param  string  $uuid  The UUID of the equipment to be deleted.
     * @return array The response array with status, message, and data.
     */
    public function delete(string $uuid): array
    {
        try {
            // Aplica soft delete al equipo especificado por medio de su uuid
            Project::where('project_uuid', $uuid)->update(['deleted_at' => now()]);
            $this->logService->create(
                $this->nameService,
                compact('uuid'),
                $this->response,
                trans('api.message_log'),
            );
            $this->response['message'] = trans('api.deleted');
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Retrieves a category by UUID
     *
     * @param  string  $uuid  The UUID of the category to retrieve
     * @return array Returns an array containing the status, message, and data of the response
     */
    public function show(string $uuid): array
    {
        try {
            // Obtiene categoría del equipo
            $project = Project::with([
                'client', 'status', 'employees.user', 'inspections'
            ])->where('project_uuid', $uuid)->first();
            $this->response['message'] = $project === null
                ? trans('api.not_found')
                : trans('api.show');
            $this->response['data'] = $project ? $project->toArray() : [];
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }

    public function status(Request $request)
    {
        try {
            // Obtiene categoría del equipo
            $project = Project::where('project_uuid', $request->project_uuid)->first();
            $status = Status::where('status_code', $request->status_uuid)->first();
            $project?->update([
                'status_id' => $status->status_id
            ]);

            $this->response['message'] = trans('api.updated');
            $this->response['data'] = $project;
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }
}
