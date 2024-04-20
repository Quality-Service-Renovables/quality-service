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

class StatusService extends Service implements ServiceInterface
{
    public string $nameService = 'status_service';

    /**
     * Create a new status
     *
     * @param  Request  $request  The request object containing the status data
     * @return array Returns an array containing the created status data
     */
    public function create(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Agrega atributos a la solicitud
            $request->merge(['status_uuid' => Str::uuid()->toString()]);
            $request->merge(['status_code' => create_slug($request->get('status'))]);
            // Registra los atributos de la solicitud a la categoria
            $status = Status::create($request->all());
            // Define parámetros de respuesta
            $this->statusCode = 201;
            $this->response['data'] = $status;
            // Registro en log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                'Create status request',
            );
            // Finaliza Transacción
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            // Parámetros de respuesta en caso de error
            $this->response['status'] = 'error';
            $this->response['message'] = $exception->getMessage();
            $this->statusCode = 500;
        }

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Update status request
     *
     * @param  Request  $request  The request object containing the data to update the status
     * @return array Returns an array containing the updated status data
     *
     * @throws Exception Throws an exception if an error occurs during the update
     */
    public function update(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Asignación de identificadores
            $slug = create_slug($request->get('status'));
            // Agregar elementos al request
            $request->merge(['status_code' => $slug]);
            // Actualiza Estado
            Status::where('status_uuid', $request->status_uuid)->update($request->all());
            // Recupera Estado Actualizado
            $equipmentUpdated = Status::where('status_uuid', $request->status_uuid)->first();
            $this->response['data'] = $equipmentUpdated;
            // Registro de log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                'Update status request',
            );
            // Confirmación de transacción
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            // Parámetros de respuesta en caso de error
            $this->response['status'] = 'error';
            $this->response['message'] = $exception->getMessage();
            $this->statusCode = 500;
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
        $this->response['data'] = Status::all();

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Delete a status record by UUID
     *
     * @param  string  $uuid  The UUID of the status record to delete
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
                'Delete status request',
            );
            // Parámetros de respuesta
            $this->response['message'] = 'Status deleted successfully';
        } catch (Exception $exception) {
            // Parámetros de respuesta en caso de error
            $this->response['status'] = 'error';
            $this->response['message'] = $exception->getMessage();
            $this->statusCode = 500;
        }

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Retrieve a status by its UUID
     *
     * @param  string  $uuid  The UUID of the status to retrieve
     * @return array Returns an array containing the status data or an empty array if the status was not found
     */
    public function show(string $uuid): array
    {
        try {
            // Obtiene estado
            $status = Status::where('status_uuid', $uuid)->first();
            $this->response['message'] = $status === null ? 'Status not found' : 'Status found';
            $this->response['data'] = $status ?? [];
        } catch (Exception $exception) {
            DB::rollBack();
            // Parámetros de respuesta en caso de error
            $this->response['status'] = 'error';
            $this->response['message'] = $exception->getMessage();
            $this->statusCode = 500;
        }

        // Respuesta del módulo
        return $this->response;
    }
}
