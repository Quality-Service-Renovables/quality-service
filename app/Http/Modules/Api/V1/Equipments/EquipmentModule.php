<?php

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Http\Modules\Api\V1\Equipments;

use App\Http\Modules\Api\Equipments\DB;
use App\Http\Modules\Applications\LogModule;
use App\Models\Equipments\Equipment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EquipmentModule
{
    public string $nameModule;

    public array $response;

    public int $status_code;

    public LogModule $logModule;

    public function __construct()
    {
        $this->nameModule = 'equipment_module';
        $this->response = [
            'status' => 'ok',
            'message' => null,
            'data' => [],
        ];
        $this->status_code = 200;
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
            $equipment = Equipment::create($data);
            $this->response['data'] = $equipment;

            $this->logModule->create(
                $this->nameModule,
                $request,
                $this->response,
                'Create equipment request',
            );

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            $this->response['status'] = 'error';
            $this->response['message'] = $exception->getMessage();
            $this->status_code = 500;
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

            $data = $request->all();
            $data['equipment_uuid'] = Str::uuid()->toString();
            $equipment = Equipment::update($data);
            $this->response['data'] = $equipment;

            $this->logModule->create(
                $this->nameModule,
                $request,
                $this->response,
                'Update equipment request',
            );

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            $this->response['status'] = 'error';
            $this->response['message'] = $exception->getMessage();
            $this->status_code = 500;
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
        $this->response['data'] = Equipment::all();

        return $this->response;
    }

    public function delete(int $equipmentId): array
    {
        try {
            Equipment::where('equipment_id', $equipmentId)->update((['deleted_at' => null]));
            $request = ['equipment_id' => $equipmentId];
            $this->logModule->create(
                $this->nameModule,
                $request,
                $this->response,
                'Create equipment request',
            );
            $this->response['message'] = 'Equipment deleted successfully';
        } catch (Exception $exception) {
            $this->response['status'] = 'error';
            $this->response['message'] = $exception->getMessage();
            $this->status_code = 500;
        }

        return $this->response;
    }
}
