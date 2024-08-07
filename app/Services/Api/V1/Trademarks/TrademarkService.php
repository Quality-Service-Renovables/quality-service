<?php

/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Trademarks;

use App\Models\Trademarks\Category;
use App\Models\Trademarks\Trademark;
use App\Services\Api\ServiceInterface;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class TrademarkService extends Service implements ServiceInterface
{
    public string $nameService = 'trademark_service';

    /**
     * Creates a new trademark based on the provided request data.
     *
     * @param Request $request The request object containing the trademark data.
     *
     * @return array The response array containing the created trademark data.
     *
     * @throws Throwable If an error occurs during the creation process.
     */
    public function create(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Agrega atributos a la solicitud
            $request->merge([
                'trademark_uuid' => Str::uuid()->toString(),
                'trademark_code' => create_slug($request->trademark),
                'ct_trademark_id' => Category::where('ct_trademark_code', $request->ct_trademark_code)
                    ->first()->ct_trademark_id,
            ]);
            // Define parámetros de respuesta
            $this->statusCode = 201;
            $this->response['message'] = trans('api.created');
            $this->response['data'] = Trademark::create($request->all());
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
     * Retrieves all trademarks with their related category and models.
     *
     * @return array The response array containing the trademarks data.
     */
    public function read(): array
    {
        $this->response['message'] = trans('api.read');
        $this->response['data'] = Trademark::with(['category', 'models'])->get();

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Updates a trademark based on the provided request.
     *
     * @param Request $request The request object containing the trademark data.
     *
     * @return array The response array containing the updated trademark data.
     */
    public function update(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Asignación de identificadores
            $request->merge([
                'trademark_code' => create_slug($request->trademark),
                'ct_trademark_id' => Category::where('ct_trademark_code', $request->ct_trademark_code)
                    ->first()->ct_trademark_id,
            ]);
            // Actualiza marca
            $trademark = Trademark::where('trademark_uuid', $request->trademark_uuid)->first();
            $trademark?->update($request->except(['ct_trademark_code']));
            $this->response['message'] = trans('api.updated');
            $this->response['data'] = $trademark;
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
     * Deletes a trademark by its UUID.
     *
     * @param string $uuid The UUID of the trademark to be deleted.
     *
     * @return array The response array containing the result of the delete operation.
     */
    public function delete(string $uuid): array
    {
        try {
            // Aplica soft delete a la marca especificada por medio de su uuid
            Trademark::where('trademark_uuid', $uuid)->update(['deleted_at' => now()]);
            // Registro en Log
            $this->logService->create(
                $this->nameService,
                compact('uuid'),
                $this->response,
                'Delete equipment category request',
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
     * Retrieves the category of a trademark based on its UUID.
     *
     * @param string $uuid The UUID of the trademark.
     *
     * @return array The response array containing the message and the category data.
     */
    public function show(string $uuid): array
    {
        try {
            // Obtiene la marca
            $trademark = Trademark::with(['category'])
                ->where('trademark_uuid', $uuid)->first();
            $this->response['message'] = $trademark === null ? trans('api.not_found') : trans('api.show');
            $this->response['data'] = $trademark ? $trademark->toArray() : [];
        } catch (Throwable $exceptions) {
            DB::rollBack();
            // Parámetros de respuesta en caso de error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }
}
