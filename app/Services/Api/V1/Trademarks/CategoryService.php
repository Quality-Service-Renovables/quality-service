<?php
/**
 * Trademarks Categories Service.
 *
 * CRUD Service
 *
 * @author   Luis Adrian Olvera Facio
 *
 * @version  1.0
 *
 * @since    2024.1
 */
/** @noinspection UnknownColumnInspection */
/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Trademarks;

use App\Models\Trademarks\Category;
use App\Services\Api\ServiceInterface;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class CategoryService extends Service implements ServiceInterface
{
    public string $nameService = 'ct_trademarks_service';

    /**
     * Create a new trademark category
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request instance
     * @return array Returns an array containing the created trademark category
     */
    public function create(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Agrega atributos a la solicitud
            $request->merge([
                'ct_trademark_uuid' => Str::uuid()->toString(),
                'ct_trademark_code' => create_slug($request->ct_trademark),
            ]);
            // Define parámetros de respuesta
            $this->statusCode = 201;
            $this->response['message'] = trans('api.created');
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
            // Parámetros de respuesta en caso de error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Retrieves a list of categories and their associated trademarks.
     *
     * @return array The response containing the message and data.
     */
    public function read(): array
    {
        $this->response['message'] = trans('api.read');
        $this->response['data'] = Category::with(['trademarks'])->get();

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Updates a category.
     *
     * @param  Request  $request  The request containing the updated category information.
     * @return array The response containing the message and data of the updated category.
     */
    public function update(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Asignación de identificadores
            $request->merge(['ct_trademark_code' => create_slug($request->ct_trademark)]);
            // Actualiza categoría de marca
            $category = Category::where('ct_trademark_uuid', $request->ct_trademark_uuid)->first();
            $category?->update($request->all());
            $this->response['message'] = trans('api.updated');
            $this->response['data'] = $category;
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
     * Delete a category
     *
     * @param  string  $uuid  The UUID of the category to delete
     * @return array The response data
     */
    public function delete(string $uuid): array
    {
        try {
            // Aplica soft delete a la categoría especificada por medio de su uuid
            Category::where('ct_trademark_uuid', $uuid)->update(['deleted_at' => now()]);
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
     * Retrieves the category and its associated trademarks based on its UUID.
     *
     * @param  string  $uuid  The UUID of the category.
     * @return array The response containing the message and data.
     */
    public function show(string $uuid): array
    {
        try {
            // Obtiene categoría de la marca
            $category = Category::where('ct_trademark_uuid', $uuid)->first();
            $this->response['message'] = $category === null ? trans('api.not_found') : trans('api.show');
            $this->response['data'] = $category ? $category->toArray() : [];
        } catch (Throwable $exceptions) {
            DB::rollBack();
            // Parámetros de respuesta en caso de error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }
}
