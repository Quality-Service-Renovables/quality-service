<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Equipments;

use App\Models\Equipments\Category;
use App\Models\Equipments\Equipment;
use App\Models\Status\Status;
use App\Models\Trademarks\Trademark;
use App\Models\Trademarks\TrademarkModel;
use App\Services\Api\ServiceInterface;
use App\Services\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EquipmentService extends Service implements ServiceInterface
{
    public string $nameService = 'equipment_service';

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
            $data = $request->all();
            $data['equipment_uuid'] = Str::uuid()->toString();
            $data['equipment_code'] = create_slug($request->get('equipment'));
            // Obtiene los identificadores de los códigos
            $data['equipment_category_id'] = Category::where('equipment_category_code', $request->equipment_category_code)->first()->equipment_category_id;
            $data['trademark_id'] = Trademark::where('trademark_code', $request->trademark_code)->first()->trademark_id;
            $data['trademark_model_id'] = TrademarkModel::where('trademark_model_code', $request->trademark_model_code)->first()->trademark_model_id;
            $data['status_id'] = Status::where('status_code', $request->status_code)->first()->status_id;
            // Registra los atributos de la solicitud al equipo
            $equipment = Equipment::create($data);
            $this->statusCode = 201;
            $this->response['data'] = $equipment;
            // Registro en log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                'Create equipment request',
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
        $this->response['data'] = Equipment::with([
            'category', 'status', 'trademark', 'model',
        ])->get();

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
            $slug = create_slug($request->get('equipment'));
            $categoryId = Category::where('equipment_category_code', $request->get('equipment_category_code'))->first()->equipment_category_id;
            $trademarkId = Trademark::where('trademark_code', $request->get('trademark_code'))->first()->trademark_id;
            $trademarkModelId = TrademarkModel::where('trademark_model_code', $request->get('trademark_model_code'))->first()->trademark_model_id;
            $statusId = Status::where('status_code', $request->get('status_code'))->first()->status_id;
            // Agregar elementos al request
            $request->merge([
                'equipment_code' => $slug,
                'equipment_category_id' => $categoryId,
                'trademark_id' => $trademarkId,
                'trademark_model_id' => $trademarkModelId,
                'status_id' => $statusId,
            ]);
            // Depura elementos incompatibles con la actualización
            $request->offsetUnset('equipment_category_code');
            $request->offsetUnset('trademark_code');
            $request->offsetUnset('trademark_model_code');
            $request->offsetUnset('status_code');
            // Actualiza Equipo
            Equipment::where('equipment_uuid', $request->equipment_uuid)->update($request->all());
            // Recupera Equipo Actualizado
            $equipmentUpdated = Equipment::where('equipment_uuid', $request->equipment_uuid)->first();
            $this->response['data'] = $equipmentUpdated;
            // Registro de log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                'Update equipment request',
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
            Equipment::where('equipment_uuid', $uuid)->update(['deleted_at' => now()]);
            $this->logService->create(
                $this->nameService,
                compact('uuid'),
                $this->response,
                'Delete equipment request',
            );
            $this->response['message'] = 'Equipment deleted successfully';
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
            $equipment = Equipment::with([
                'category', 'status', 'trademark', 'model',
            ])->where('equipment_uuid', $uuid)->first();
            $this->response['message'] = $equipment === null ? 'Equipment not found' : 'Equipment found';
            $this->response['data'] = $equipment ?? [];
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
