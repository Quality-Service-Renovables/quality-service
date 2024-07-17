<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\OIls;

use App\Models\Oils\Category;
use App\Services\Api\ServiceInterface;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class CategoryService extends Service implements ServiceInterface
{
    public string $nameService = 'ct_oil_service';

    /**
     * Create a new oil category
     *
     * @param  Request  $request  The request object containing the category data
     * @return array Returns an array containing the response data
     */
    public function create(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Agrega atributos a la solicitud
            $request->merge([
                'ct_oil_uuid' => Str::uuid()->toString(),
                'ct_oil_code' => create_slug($request->get('ct_oil')),
            ]);
            // Define parámetros de respuesta
            $this->statusCode = 201;
            $this->response['data'] = Category::create($request->all());
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
     * Update a category
     *
     * @param  Request  $request  The request object
     * @return array Returns an array containing the updated category data
     */
    public function update(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Agregar elementos al request
            $request->merge([
                'ct_oil_code' => create_slug($request->ct_oil),
            ]);
            // Actualiza categoría de aceite
            $equipment = Category::where('ct_oil_uuid', $request->ct_oil_uuid)->first();
            $equipment?->update($request->all());
            // Respuesta de servicio
            $this->response['data'] = $equipment;
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
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Reads all categories from the database.
     *
     * @return array The response data containing the categories.
     */
    public function read(): array
    {
        $this->response['data'] = Category::all();
        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Deletes a category from the database.
     *
     * @param  string  $uuid  The UUID of the category to be deleted.
     * @return array The response data indicating the success of
     */
    public function delete(string $uuid): array
    {
        try {
            // Aplica soft delete a la categoría del aceite especificado por medio de su uuid
            Category::where('ct_oil_uuid', $uuid)->update(['deleted_at' => now()]);
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
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Retrieves a category from the database by its UUID.
     *
     * @param  string  $uuid  The UUID of the category.
     * @return array The response data containing the category.
     */
    public function show(string $uuid): array
    {
        try {
            // Obtiene categoría del aceite
            $category = Category::where('ct_oil_uuid', $uuid)->first();
            $this->response['message'] = $category === null ? trans('api.not_found') : trans('api.read');
            $this->response['data'] = $category ? $category->toArray() : [];
        } catch (Throwable $exceptions) {
            DB::rollBack();
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }
}
