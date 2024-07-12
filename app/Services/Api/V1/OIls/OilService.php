<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\OIls;

use App\Models\Oils\Category;
use App\Models\Oils\Oil;
use App\Models\Trademarks\Trademark;
use App\Models\Trademarks\TrademarkModel;
use App\Services\Api\ServiceInterface;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class OilService extends Service implements ServiceInterface
{
    public string $nameService = 'oil_service';

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
                'oil_uuid' => Str::uuid()->toString(),
                'oil_code' => create_slug($request->oil),
            ]);
            // Obtiene los identificadores de los códigos
            $request->merge(['ct_oil_id' => Category::where('ct_oil_code', $request->ct_oil_code)->first()->ct_oil_id]);
            $request->merge(['trademark_id' => Trademark::where('trademark_code', $request->trademark_code)->first()->trademark_id]);
            $request->merge(['trademark_model_id' => TrademarkModel::where('trademark_model_code', $request->trademark_model_code)->first()->trademark_model_id]);
            // Registra los atributos de la solicitud a la categoría
            $category = Oil::create($request->except(['ct_oil_code', 'trademark_code', 'trademark_model_code']));
            // Define parámetros de respuesta
            $this->statusCode = 201;
            $this->response['data'] = $category;
            // Registro en log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                'Create oil request',
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
     * Update an oil record
     *
     * @param Request $request The request object containing the oil data
     *
     * @return array Returns an array containing the response data
     */
    public function update(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Agrega atributos a la solicitud y obtiene los identificadores de los códigos
            $request->merge([
                'oil_code' => create_slug($request->oil),
                'ct_oil_id' => Category::where('ct_oil_code', $request->ct_oil_code)->first()->ct_oil_id,
                'trademark_id' => Trademark::where('trademark_code', $request->trademark_code)->first()->trademark_id,
                'trademark_model_id' => TrademarkModel::where('trademark_model_code', $request->trademark_model_code)->first()->trademark_model_id,
            ]);
            // Actualiza aceite
            Oil::where('oil_uuid', $request->oil_uuid)->update($request->except(['ct_oil_code', 'trademark_code', 'trademark_model_code']));
            // Recupera aceite actualizado
            $oilUpdated = Oil::where('oil_uuid', $request->oil_uuid)->first();
            $this->response['data'] = $oilUpdated;
            // Registro de log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                'Update oil request',
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
     * Retrieve all equipment data
     *
     * @return array Returns an array containing the equipment data
     */
    public function read(): array
    {
        $this->response['data'] = Oil::with('category', 'trademark.model')->get();

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
            Oil::where('oil_uuid', $uuid)->update(['deleted_at' => now()]);
            // Registro en Log
            $this->logService->create(
                $this->nameService,
                compact('uuid'),
                $this->response,
                'Delete oil request',
            );
            // Parámetros de respuesta
            $this->response['message'] = 'Oil deleted successfully';
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
            $category = Oil::where('oil_uuid', $uuid)->first();
            $this->response['message'] = $category === null ? trans('api.not_found') : trans('api.show');
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
