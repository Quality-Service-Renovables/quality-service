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
use App\Models\Failures\Failure;
use App\Services\Api\ServiceInterface;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class FailureService extends Service implements ServiceInterface
{
    public string $nameService = 'failure_service';

    /**
     * Creates a new failure.
     *
     * @param Request $request The request object.
     *
     * @return array The response data.
     *
     */
    public function create(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Agrega atributos a la solicitud
            $request->merge([
                'failure_uuid' => Str::uuid()->toString(),
                'failure_code' => create_slug($request->failure),
                'ct_failure_id' => Category::where('ct_failure_code', $request->ct_failure_code)
                    ->first()->ct_failure_id,
            ]);
            // Respuesta del servicio
            $this->statusCode = 201;
            $this->response['message'] = trans('api.created');
            $this->response['data'] = Failure::create($request->except('ct_failure_code'));
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
        $this->response['data'] = Failure::with(['category'])->get();

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
            $request->failure_code = create_slug($request->failure);
            $request->merge([
                'ct_failure_id' => Category::where('ct_failure_code', $request->ct_failure_code)
                    ->first()->ct_failure_id,
            ]);
            // Actualiza falla
            $failure = Failure::where('failure_uuid', $request->failure_uuid)->first();
            $failure?->update($request->except(['ct_failure_code']));
            // Respuesta de servicio
            $this->response['message'] = trans('api.updated');
            $this->response['data'] = $failure;
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
            Failure::where('failure_uuid', $uuid)->update(['deleted_at' => now()]);
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
     * Retrieves the information of a failure with its category.
     *
     * @param string $uuid The UUID of the equipment.
     *
     * @return array The formatted response data.
     *
     * @throws \Throwable
     */
    public function show(string $uuid): array
    {
        try {
            // Obtiene la información de la falla con su respectiva categoría
            $failure = Failure::with(['category'])
                ->where('failure_uuid', $uuid)
                ->first();
            $this->response['message'] = $failure === null
                ? trans('api.not_found')
                : trans('api.show');
            $this->response['data'] = $failure ? $failure->toArray() : [];
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }
}
