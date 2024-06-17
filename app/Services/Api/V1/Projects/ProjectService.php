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
use App\Services\Api\ServiceInterface;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class ProjectService extends Service implements ServiceInterface
{
    //TODO Pendientes de proyectos:
    /**
     * • Nuevo proyecto
     * • Asignar proyecto a trabajadores
     * • Seguimiento de proyecto
     * • Editar
     * • Eliminar
     * • Iniciar proyecto
     * • Cerrar proyecto
     * • Validar proyecto
     * LISTA DE PROYECTOS
     * • Iniciar inspección
     * • Selección de zona (con sugerencia
     * con base a ubicación del técnico)
     * • Selección de generador
     * • Agregar fotos (con opción de
     * comentarios por foto)
     * • Agregar comentarios generales
     * • Pausar inspección
     * • Cargar información a la nube
     * • Finalizar inspección
     * • Ver información del proyecto
     */
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
                    'proceso_creado')
                    ->first()->status_id,
                'client_id' => Client::where('client_uuid',
                    '=',
                    $request->client_uuid
                )->first()->client_id,
            ]);
            // Registra los atributos de la solicitud
            $this->statusCode = 201;
            $this->response['message'] = trans('api.created');
            $this->response['data'] = Project::create($request->all());
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
     * Retrieve all equipment data
     *
     * @return array Returns an array containing the equipment data
     */
    public function read(): array
    {
        $this->response['message'] = trans('api.read');
        $this->response['data'] = Project::with(['client', 'status'])->get();

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
            // Si el estado es correspondiente al proyectos
            if (($status && $status->category) && $status->category->ct_status_code === 'proyecto') {
                // Si el proyecto ha sido cancelado y no se proporcionan comentarios, no es posible proceder.
                if ($status->status_code === 'proyecto_cancelado' && $request->comments === '') {
                    $this->statusCode = 422;
                    $this->response['message'] = trans('api.project_cancelled');
                } else {
                    // Agrega atributos a la solicitud
                    $request->merge([
                        'status_id' => $status->status_id,
                        'client_id' => Client::where('client_uuid',
                            '=',
                            $request->client_uuid
                        )->first()->client_id,
                    ]);
                    // Actualiza Equipo
                    $project = Project::where('project_uuid', $request->project_uuid)->first();
                    $project?->update($request->except([
                        'status_uuid', 'client_uuid',
                    ]));
                    $this->response['message'] = trans('api.updated');
                    $this->response['data'] = $project;
                    // Registro de log
                    $this->logService->create(
                        $this->nameService,
                        $request->all(),
                        $this->response,
                        trans('api.message_log'),
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
                'client', 'status',
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
}