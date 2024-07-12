<?php
/**
 * Client Service.
 *
 * Register clients
 *
 * @author   Luis Adrian Olvera Facio
 *
 * @version  1.0
 *
 * @since    2024.1
 */
/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Clients;

use App\Models\Clients\Client;
use App\Services\Api\ServiceInterface;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

/**
 * Class ClientService
 */
class ClientService extends Service implements ServiceInterface
{
    public string $nameService = 'client_service';

    /**
     * Create a new client
     *
     * @param Request $request The request object
     *
     * @return array Returns an array containing the created client data
     */
    public function create(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Agrega atributos a la solicitud
            $request->merge([
                'client_uuid' => Str::uuid()->toString(),
                'client_code' => create_slug($request->client),
            ]);
            $this->storeFile($request, 'logo_store', 'clients', 'logo');
            // Registra los atributos de la solicitud al cliente
            $client = Client::create($request->except(['logo_store']));
            // Define parámetros de respuesta
            $this->statusCode = 201;
            $this->response['message'] = trans('api.created');
            $this->response['data'] = $client;
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
     * Update client data
     *
     * @param Request $request The request object containing the updated data
     *
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
            // Si se detecta que se requiere actualizar el logo, se procede a guardar el nuevo logo.
            if ($request->logo_store) {
                $this->storeFile($request, 'logo_store', 'clients', 'logo');
            }
            // Actualiza el cliente
            $client = Client::where('client_uuid', $request->client_uuid)->first();
            $client?->update($request->except(['logo_store']));
            // Respuesta del servicio
            $this->response['data'] = $client;
            // Registro de log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                trans('api.message_log'),
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
     * Retrieve all client data
     *
     * @return array Returns an array containing the client data
     */
    public function read(): array
    {
        $this->response['message'] = trans('api.read');
        $this->response['data'] = Client::with(['config'])->get();

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Delete client by UUID.
     *
     * @param string $uuid The UUID of the client to be deleted.
     *
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
     * Retrieves a category by UUID
     *
     * @param string $uuid The UUID of the category to retrieve
     *
     * @return array Returns an array containing the status, message, and data of the response
     */
    public function show(string $uuid): array
    {
        try {
            // Obtiene client del equipo
            $client = Client::with(['config'])
                ->where('client_uuid', $uuid)
                ->first();
            $this->response['message'] = $client === null
                ? trans('api.not_found')
                : trans('api.show');
            // Si bien se puede retornar la colección, se regresa como arreglo para evitar alerta de complementación
            $this->response['data'] = $client ? $client->toArray() : [];
        } catch (Throwable $exceptions) {
            DB::rollBack();
            // Parámetros de respuesta en caso de error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }
}
