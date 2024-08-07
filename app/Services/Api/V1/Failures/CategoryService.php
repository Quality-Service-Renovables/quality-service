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

namespace App\Services\Api\V1\Failures;

use App\Models\Failures\Category;
use App\Services\Api\ServiceInterface;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class CategoryService extends Service implements ServiceInterface
{
    public string $nameService = 'ct_failure_service';

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
            $request->merge([
                'ct_failure_uuid' => Str::uuid()->toString(),
                'ct_failure_code' => create_slug($request->ct_failure),
            ]);
            // Registra los atributos de la solicitud a la categoría de la falla
            $failureCategory = Category::create($request->all());
            $this->statusCode = 201;
            $this->response['message'] = trans('api.created');
            $this->response['data'] = $failureCategory;
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
        $this->response['data'] = Category::all();

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
            $request->merge(['ct_failure_code' => create_slug($request->ct_failure)]);
            // Actualiza la categoría de falla
            $category = Category::where('ct_failure_uuid', $request->ct_failure_uuid)->first();
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
            // Manejo del error
            $this->setExceptions($exceptions);
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
            Category::where('ct_failure_uuid', $uuid)
                ->update(['deleted_at' => now()]);
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
     * @param string $uuid The UUID of the category to retrieve
     *
     * @return array Returns an array containing the status, message, and data of the response
     */
    public function show(string $uuid): array
    {
        try {
            // Obtiene categoría del equipo
            $failureCategory = Category::where('ct_failure_uuid', $uuid)->first();
            $this->response['message'] = $failureCategory === null
                ? trans('api.not_found')
                : trans('api.show');
            $this->response['data'] = $failureCategory;
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }
}
