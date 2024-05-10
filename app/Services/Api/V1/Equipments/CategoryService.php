<?php
/**
 * Equipment Categories Service.
 *
 * Register equipment categories
 *
 * @author   Luis Adrian Olvera Facio
 *
 * @version  1.0
 *
 * @since    2024.1
 */

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Equipments;

use App\Models\Equipments\Category;
use App\Services\Api\ServiceInterface;
use App\Services\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * The name of the service.
 *
 * @var string
 */
class CategoryService extends Service implements ServiceInterface
{
    public string $nameService = 'ct_equipment_service';

    /**
     * Create a new equipment category
     *
     * @param  Request  $request  The request object
     * @return array Returns an array containing the response data
     */
    public function create(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Agrega atributos a la solicitud
            $request->merge(['ct_equipment_uuid' => Str::uuid()->toString()]);
            $request->merge(['ct_equipment_code' => create_slug($request->get('ct_equipment'))]);
            // Registra los atributos de la solicitud a la categoria
            $category = Category::create($request->all());
            // Define parámetros de respuesta
            $this->statusCode = 201;
            $this->response['message'] = trans('api.created');
            $this->response['data'] = $category;
            // Registro en log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                trans('api.message_log'),
            );
            // Finaliza Transacción
            DB::commit();
        } catch (Exception $exceptions) {
            DB::rollBack();
            // Parámetros de respuesta en caso de error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Update equipment
     *
     * @param  Request  $request  The request object containing the updated equipment data
     * @return array Returns an array containing the updated equipment data or error response
     */
    public function update(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Asignación de identificadores
            $slug = create_slug($request->get('ct_equipment'));
            // Agregar elementos al request
            $request->merge([
                'ct_equipment_code' => $slug,
            ]);
            // Actualiza categoria de equipo
            Category::where('ct_equipment_uuid', $request->ct_equipment_uuid)->update($request->all());
            // Recupera categoria de equipo Actualizado
            $categoryUpdated = Category::where('ct_equipment_uuid', $request->ct_equipment_uuid)->first();
            $this->response['message'] = trans('api.updated');
            $this->response['data'] = $categoryUpdated;
            // Registro de log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                trans('api.message_log'),
            );
            // Confirmación de transacción
            DB::commit();
        } catch (Exception $exceptions) {
            DB::rollBack();
            // Parámetros de respuesta en caso de error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Read all categories from the database.
     *
     * @return array The response array containing the fetched categories.
     */
    public function read(): array
    {
        $this->response['message'] = trans('api.readed');
        $this->response['data'] = Category::all();

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Delete a category from the database.
     *
     * @param  string  $uuid  The UUID of the category to delete.
     * @return array The response array indicating the result of the delete operation.
     */
    public function delete(string $uuid): array
    {
        try {
            // Aplica soft delete a la categoria del equipo especificado por medio de su uuid
            Category::where('ct_equipment_uuid', $uuid)->update(['deleted_at' => now()]);
            // Registro en Log
            $this->logService->create(
                $this->nameService,
                compact('uuid'),
                $this->response,
                'Delete equipment category request',
            );
            // Parámetros de respuesta
            $this->response['message'] = trans('api.deleted');
        } catch (Exception $exceptions) {
            // Parámetros de respuesta en caso de error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Show a specific category from the database based on its UUID.
     *
     * @param  string  $uuid  The UUID of the category.
     * @return array The response array containing the category information.
     */
    public function show(string $uuid): array
    {
        try {
            // Obtiene categoria del equipo
            $category = Category::where('ct_equipment_uuid', $uuid)->first();
            $this->response['message'] = $category === null
                ? trans('api.not_found')
                : trans('api.show');
            $this->response['data'] = $category ?? [];
        } catch (Exception $exceptions) {
            DB::rollBack();
            // Parámetros de respuesta en caso de error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }
}
