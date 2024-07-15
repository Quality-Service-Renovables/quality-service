<?php

/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Trademarks;

use App\Models\Trademarks\Trademark;
use App\Models\Trademarks\TrademarkModel;
use App\Services\Api\ServiceInterface;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class TrademarkModelService extends Service implements ServiceInterface
{
    public string $nameService = 'trademark_model_model_service';

    /**
     * Creates a new TrademarkModel record.
     *
     * @param Request $request The HTTP request object.
     *
     * @return array The array containing the response data.
     */
    public function create(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Recupera el identificador de la marca
            $trademark = Trademark::where('trademark_code', $request->trademark_code)->first();
            // Agrega atributos a la solicitud
            $request->merge([
                'trademark_model_uuid' => Str::uuid()->toString(),
                'trademark_model_code' => create_slug($request->trademark_model),
                'trademark_id' => $trademark->trademark_id,
            ]);
            // Define parámetros de respuesta
            $this->statusCode = 201;
            $this->response['message'] = trans('api.created');
            $this->response['data'] = TrademarkModel::create($request->all());
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
     * Retrieves the list of TrademarkModels with their respective trademarks.
     *
     * @return array The array containing the response data.
     */
    public function read(): array
    {
        $this->response['message'] = trans('api.read');
        $this->response['data'] = TrademarkModel::with(['trademark'])->get();

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Updates a TrademarkModel based on the provided request data.
     *
     * @param \Illuminate\Http\Request $request The request data.
     *
     * @return array The array containing the response data.
     */
    public function update(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Asignación de identificadores
            $slug = create_slug($request->trademark_model);
            // Agregar elementos al request
            $request->merge(['trademark_model_code' => $slug]);
            // Depura elementos incompatibles con la actualización o bien usar el except en el request
            $request->offsetUnset('trademark_code');
            // Actualiza model de marca
            $trademark = TrademarkModel::where('trademark_model_uuid', $request->trademark_model_uuid)->first();
            $trademark?->update($request->all());
            // Respuesta del servicio
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
     * Delete a trademark by UUID
     *
     * @param string $uuid The UUID of the trademark to be deleted
     *
     * @return array Returns an array containing the response data
     */
    public function delete(string $uuid): array
    {
        try {
            // Aplica soft delete al modelo especificado por medio de su uuid
            TrademarkModel::where('trademark_model_uuid', $uuid)->update(['deleted_at' => now()]);
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
     * Show a trademark model by UUID
     *
     * @param string $uuid The UUID of the trademark model
     *
     * @return array Returns an array containing the trademark model data
     */
    public function show(string $uuid): array
    {
        try {
            // Obtiene modelo de la marca
            $trademarkModel = TrademarkModel::with(['trademark'])
                ->where('trademark_model_uuid', $uuid)->first();
            $this->response['message'] = $trademarkModel === null
                ? trans('api.not_found')
                : trans('api.show');
            $this->response['data'] = $trademarkModel ? $trademarkModel->toArray() : [];
        } catch (Throwable $exceptions) {
            DB::rollBack();
            // Parámetros de respuesta en caso de error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }
}
