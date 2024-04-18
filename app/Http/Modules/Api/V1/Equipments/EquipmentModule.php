<?php

/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUndefinedMethodInspection */

namespace App\Http\Modules\Api\V1\Equipments;

use App\Http\Modules\Applications\LogModule;
use App\Models\Equipments\Category;
use App\Models\Equipments\Equipment;
use App\Models\Status;
use App\Models\Trademarks\Trademark;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EquipmentModule
{
    public string $nameModule;

    public array $response;

    public int $statusCode;

    public LogModule $logModule;

    /**
     * Class constructor.
     * Sets the name module, response array, status code and log module.
     *
     * @return void
     */
    public function __construct()
    {
        $this->nameModule = 'equipment_module';
        $this->response = [
            'status' => 'ok',
            'message' => null,
            'data' => [],
        ];
        $this->statusCode = 200;
        $this->logModule = new LogModule();
    }

    /**
     * Create a new equipment
     *
     * @param  Request  $request  The request object
     * @return array Returns an array containing the created equipment data
     */
    public function create(Request $request): array
    {
        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['equipment_uuid'] = Str::uuid()->toString();
            $data['equipment_code'] = create_slug($request->get('equipment'));

            $data['equipment_category_id'] = Category::where('equipment_category_code', $request->get('equipment_category_code'))->first()->equipment_category_id;
            $data['trademark_id'] = Trademark::where('trademark_code', $request->get('trademark_code'))->first()->trademark_id;
            $data['status_id'] = Status::where('status_code', $request->get('status_code'))->first()->status_id;

            $equipment = Equipment::create($data);
            $this->statusCode = 201;
            $this->response['data'] = $equipment;

            $this->logModule->create(
                $this->nameModule,
                $request->all(),
                $this->response,
                'Create equipment request',
            );

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            $this->response['status'] = 'error';
            $this->response['message'] = $exception->getMessage();
            $this->statusCode = 500;
        }

        return $this->response;
    }

    /**
     * Update equipment data
     *
     * @param  Request  $request  The request object containing the updated data
     * @return array Returns an array containing the updated equipment data
     */
    public function update(Request $request): array
    {
        try {
            DB::beginTransaction();
            // Asignación de identificadores
            $slug = create_slug($request->get('equipment'));
            $categoryId = Category::where('equipment_category_code', $request->get('equipment_category_code'))->first()->equipment_category_id;
            $trademarkId = Trademark::where('trademark_code', $request->get('trademark_code'))->first()->trademark_id;
            $statusId = Status::where('status_code', $request->get('status_code'))->first()->status_id;
            // Agregar elementos al request
            $request->merge([
                'equipment_code' => $slug,
                'equipment_category_id' => $categoryId,
                'trademark_id' => $trademarkId,
                'status_id' => $statusId,
            ]);
            // Depura elementos incompatibles con la actualización
            $request->offsetUnset('equipment_category_code');
            $request->offsetUnset('trademark_code');
            $request->offsetUnset('status_code');
            // Actualiza Equipo
            Equipment::where('equipment_uuid', $request->equipment_uuid)->update($request->all());
            // Recupera Equipo Actualizado
            $equipmentUpdated = Equipment::where('equipment_uuid', $request->equipment_uuid)->first();
            $this->response['data'] = $equipmentUpdated;
            // Registro de log
            $this->logModule->create(
                $this->nameModule,
                $request->all(),
                $this->response,
                'Update equipment request',
            );

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            $this->response['status'] = 'error';
            $this->response['message'] = $exception->getMessage();
            $this->statusCode = 500;
        }

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
            'category', 'status', 'trademark',
        ])->get();

        return $this->response;
    }

    /**
     * Delete equipment by UUID.
     *
     * @param  string  $uuid  The UUID of the equipment to be deleted.
     * @return array The response array with status, message, and data.
     */
    public function delete(string $uuid): array
    {
        try {
            // Aplica soft delete al equipo especificado por medio de su uuid
            Equipment::where('equipment_uuid', $uuid)->update(['deleted_at' => now()]);
            $this->logModule->create(
                $this->nameModule,
                compact('uuid'),
                $this->response,
                'Delete equipment request',
            );
            $this->response['message'] = 'Equipment deleted successfully';
        } catch (Exception $exception) {
            $this->response['status'] = 'error';
            $this->response['message'] = $exception->getMessage();
            $this->statusCode = 500;
        }

        return $this->response;
    }
}
