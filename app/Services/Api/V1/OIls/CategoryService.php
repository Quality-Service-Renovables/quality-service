<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\OIls;

use App\Models\Oils\Category;
use App\Services\Api\ServiceInterface;
use App\Services\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryService extends Service implements ServiceInterface
{
    public string $nameService = 'oil_category_service';

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
            $request->merge(['oil_category_uuid' => Str::uuid()->toString()]);
            $request->merge(['oil_category_code' => create_slug($request->get('oil_category'))]);
            // Registra los atributos de la solicitud a la categoria
            $category = Category::create($request->all());
            // Define parámetros de respuesta
            $this->statusCode = 201;
            $this->response['data'] = $category;
            // Registro en log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                'Create oil category request',
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
            // Asignación de identificadores
            $slug = create_slug($request->get('oil_category'));
            // Agregar elementos al request
            $request->merge([
                'oil_category_code' => $slug,
            ]);
            // Actualiza categoria de aceite
            Category::where('oil_category_uuid', $request->oil_category_uuid)->update($request->all());
            // Recupera categoria de aceite actualizada
            $equipmentUpdated = Category::where('oil_category_uuid', $request->oil_category_uuid)->first();
            $this->response['data'] = $equipmentUpdated;
            // Registro de log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                'Update oil category request',
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
            // Aplica soft delete a la categoria del aceite especificado por medio de su uuid
            Category::where('oil_category_uuid', $uuid)->update(['deleted_at' => now()]);
            // Registro en Log
            $this->logService->create(
                $this->nameService,
                compact('uuid'),
                $this->response,
                'Delete equipment category request',
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
     * Retrieves a category from the database by its UUID.
     *
     * @param  string  $uuid  The UUID of the category.
     * @return array The response data containing the category.
     */
    public function show(string $uuid): array
    {
        try {
            // Obtiene categoria del aceite
            $category = Category::where('oil_category_uuid', $uuid)->first();
            $this->response['message'] = $category === null ? 'Category not found' : 'Category found';
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
