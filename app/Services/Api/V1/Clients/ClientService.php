<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Clients;

use App\Models\Clients\Client;
use App\Services\Api\ServiceInterface;
use App\Services\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientService extends Service implements ServiceInterface
{
    public string $nameService = 'client_service';

    /**
     * Create a new client
     *
     * @param  Request  $request  The request object
     * @return array Returns an array containing the created client data
     */
    public function create(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Agrega atributos a la solicitud
            $request->merge(['client_uuid' => Str::uuid()->toString()]);
            $request->merge(['client_code' => create_slug($request->client)]);
            // Registra los atributos de la solicitud al cliente
            $client = Client::create($request->all());
            // Define parámetros de respuesta
            $this->statusCode = 201;
            $this->response['data'] = $client;
            // Registro en log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                'Create client request',
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
     * Update client data
     *
     * @param  Request  $request  The request object containing the updated data
     * @return array Returns an array containing the updated client data
     */
    public function update(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Asignación de identificadores
            $slug = create_slug($request->get('client'));
            // Agregar elementos al request
            $request->merge(['client_code' => $slug]);
            // Actualiza Equipo
            Client::where('client_uuid', $request->client_uuid)->update($request->all());
            // Recupera Cliente Actualizado
            $clientUpdated = Client::where('client_uuid', $request->client_uuid)->first();
            $this->response['data'] = $clientUpdated;
            // Registro de log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                'Update client request',
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
     * Retrieve all client data
     *
     * @return array Returns an array containing the client data
     */
    public function read(): array
    {
        $this->response['data'] = Client::all();

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Delete client by UUID.
     *
     * @param  string  $uuid  The UUID of the client to be deleted.
     * @return array The response array with status, message, and data.
     */
    public function delete(string $uuid): array
    {
        try {
            // Aplica soft delete al equipo especificado por medio de su uuid
            Client::where('client_uuid', $uuid)->update(['deleted_at' => now()]);
            // Registro en Log
            $this->logService->create(
                $this->nameService,
                compact('uuid'),
                $this->response,
                'Delete client category request',
            );
            // Parámetros de respuesta
            $this->response['message'] = 'Category deleted successfully';
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
     * Retrieves a category by UUID
     *
     * @param  string  $uuid  The UUID of the category to retrieve
     * @return array Returns an array containing the status, message, and data of the response
     */
    public function show(string $uuid): array
    {
        try {
            // Obtiene client del equipo
            $client = Client::where('client_uuid', $uuid)->first();
            $this->response['message'] = $client === null ? 'Category not found' : 'Category found';
            $this->response['data'] = $client ?? [];
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
