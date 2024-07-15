<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Status;

use App\Models\Status\Status;
use App\Services\Api\ServiceInterface;
use App\Services\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

/**
 * Class StatusService
 *
 * A service class to handle status-related operations.
 */
class StatusService extends Service implements ServiceInterface
{
    public string $nameService = 'status_service';

    /**
     * Create a new status
     *
     * @param Request $request The request object containing the status data
     *
     * @return array Returns an array containing the created status data
     */
    public function create(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Agrega atributos a la solicitud
            $request->merge([
                'status_uuid' => Str::uuid()->toString(),
                'status_code' => create_slug($request->status),
            ]);
            // Define parámetros de respuesta
            $this->statusCode = 201;
            $this->response['message'] = trans('api.created');
            $this->response['data'] = Status::create($request->all());
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
            // Parámetros de respuesta en caso de error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Update status request
     *
     * @param Request $request The request object containing the data to update the status
     *
     * @return array Returns an array containing the updated status data
     *
     * @throws Exception Throws an exception if an error occurs during the update
     */
    public function update(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Agregar elementos al request
            $request->merge(['status_code' => create_slug($request->status)]);
            // Actualiza Estado
            $status = Status::where('status_uuid', $request->status_uuid)->first();
            $status?->update($request->all());
            // Respuesta de servicio
            $this->response['message'] = trans('api.updated');
            $this->response['data'] = $status;
            // Registro de log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                trans('api.updated'),
            );
            // Confirmación de transacción
            DB::commit();
        } catch (Throwable $exceptions) {
            DB::rollBack();
            // Parámetros de respuesta en caso de error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Retrieves all status data from the database and returns it as an array.
     *
     * @return array The array containing all status data.
     */
    public function read(): array
    {
        $this->response['message'] = trans('api.read');
        $this->response['data'] = Status::all();

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Delete a status record by UUID
     *
     * @param string $uuid The UUID of the status record to delete
     *
     * @return array Returns an array containing the response data
     */
    public function delete(string $uuid): array
    {
        try {
            // Aplica soft delete del estado especificado por medio de su uuid
            Status::where('status_uuid', $uuid)->update(['deleted_at' => now()]);
            // Registro en Log
            $this->logService->create(
                $this->nameService,
                compact('uuid'),
                $this->response,
                trans('api.message_log'),
            );
            // Parámetros de respuesta
            $this->response['message'] = trans('api.deleted');
        } catch (Throwable $exceptions) {
            // Parámetros de respuesta en caso de error
            $this->setExceptions($exceptions);
        }
        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Retrieve a status by its UUID
     *
     * @param string $uuid The UUID of the status to retrieve
     *
     * @return array Returns an array containing the status data or an empty array if the status was not found
     */
    public function show(string $uuid): array
    {
        try {
            // Obtiene estado
            $status = Status::where('status_uuid', $uuid)->first();
            $this->response['message'] = $status === null
                ? trans('api.not_found')
                : trans('api.show');
            $this->response['data'] = $status ? $status->toArray() : [];
        } catch (Throwable $exceptions) {
            DB::rollBack();
            // Parámetros de respuesta en caso de error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }
}
