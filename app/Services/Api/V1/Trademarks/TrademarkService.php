<?php
/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Trademarks;

use App\Models\Trademarks\Trademark;
use App\Services\Api\ServiceInterface;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TrademarkService extends Service implements ServiceInterface
{
    public string $nameService = 'trademark_service';

    /**
     * Create a new equipment
     *
     * @param Request $request The request object
     *
     * @return array Returns an array containing the created equipment data
     */
    public function create(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Agrega atributos a la solicitud
            $request->merge(['trademark_uuid' => Str::uuid()->toString()]);
            $request->merge(['trademark_code' => create_slug($request->trademark)]);
            // Registra los atributos de la solicitud a la categoria
            $trademark = Trademark::create($request->all());
            // Define parámetros de respuesta
            $this->statusCode = 201;
            $this->response['data'] = $trademark;
            // Registro en log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                'Create trademark request',
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
     * Retrieve all equipment data
     *
     * @return array Returns an array containing the equipment data
     */
    public function read(): array
    {
        $this->response['data'] = Trademark::with(['models'])->get();

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Update equipment data
     *
     * @param Request $request The request object containing the updated data
     *
     * @return array Returns an array containing the updated equipment data
     */
    public function update(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Asignación de identificadores
            $slug = create_slug($request->trademark);
            // Agregar elementos al request
            $request->merge([
                'trademark' => $slug,
            ]);
            // Actualiza Equipo
            Trademark::where('trademark_uuid', $request->trademark_uuid)->update($request->all());
            // Recupera Equipo Actualizado
            $equipmentUpdated = Trademark::where('trademark_uuid', $request->trademark_uuid)->first();
            $this->response['data'] = $equipmentUpdated;
            // Registro de log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                'Update trademark request',
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
     * Delete equipment by UUID.
     *
     * @param string $uuid The UUID of the equipment to be deleted.
     *
     * @return array The response array with status, message, and data.
     */
    public function delete(string $uuid): array
    {
        try {
            // Aplica soft delete al equipo especificado por medio de su uuid
            Trademark::where('trademark_uuid', $uuid)->update(['deleted_at' => now()]);
            // Registro en Log
            $this->logService->create(
                $this->nameService,
                compact('uuid'),
                $this->response,
                'Delete equipment category request',
            );
            // Parámetros de respuesta
            $this->response['message'] = 'Trademark deleted successfully';
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
     * @param string $uuid The UUID of the category to retrieve
     *
     * @return array Returns an array containing the status, message, and data of the response
     */
    public function show(string $uuid): array
    {
        try {
            // Obtiene categoria del equipo
            $category = Trademark::where('trademark_uuid', $uuid)->first();
            $this->response['message'] = $category === null ? 'Trademark not found' : 'Category found';
            $this->response['data'] = $category ?? [];
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
