<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Inspections;

use App\Models\Equipments\Equipment;
use App\Models\Inspections\Equipment as InspectionEquipment;
use App\Models\Inspections\Inspection;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class EquipmentService extends Service
{
    public string $nameService = 'inspection_equipment';

    public function create(Request $request): array
    {
        try {
            // Control Transaction
            DB::beginTransaction();
            $inspection = Inspection::where('inspection_uuid', $request->inspection_uuid)->first();
            $equipment = Equipment::where('equipment_uuid', $request->equipment_uuid)->first();
            // Create Register
            $inspectionEquipment = InspectionEquipment::create([
                'inspection_equipment_uuid' => Str::uuid()->toString(),
                'inspection_id' => $inspection->inspection_id,
                'equipment_id' => $equipment->equipment_id,
            ]);
            // Set Response
            $this->statusCode = 201;
            $this->response['message'] = trans('api.created');
            $this->response['data'] = $inspectionEquipment;
            // Set Log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                'Create new equipment inspection',
                $request->user()->id,
            );
            // Commit Transaction
            DB::commit();
        } catch (Throwable $exceptions) {
            DB::rollBack();
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Response
        return $this->response;
    }

    /**
     * Retrieve the list of categories.
     *
     * @return array The response containing the list of categories.
     *
     * @throws \Exception If there is an error retrieving the list of categories.
     */
    public function read(): array
    {
        try {
            $this->response['message'] = trans('api.read');
            $this->response['data'] = InspectionEquipment::with(['equipment'])->get();
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        return $this->response;
    }

    /**
     * Update a category.
     *
     * @param  \Illuminate\Http\Request  $request  The request data.
     * @return array The response containing the updated category.
     *
     * @throws \Exception If there is an error updating the category.
     */
    public function update(Request $request): array
    {
        try {
            // Control Transaction
            DB::beginTransaction();

            $inspection = Inspection::where('inspection_uuid', $request->inspection_uuid)->first();
            $equipment = Equipment::where('equipment_uuid', $request->equipment_uuid)->first();
            // Update Register
            $inspectionEquipment = InspectionEquipment::with(['equipment'])
                ->where('inspection_equipment_uuid', $request->inspection_equipment_uuid)
                ->first();
            // Si el $category existe (no es nulo), actualízalo con todos los datos de la solicitud.
            $inspectionEquipment?->update([
                'equipment_id' => $equipment->equipment_id,
                'inspection_id' => $inspection->inspection_id,
            ]);
            // Set Response
            $this->response['message'] = trans('api.updated');
            $this->response['data'] = $inspectionEquipment;
            // Set Log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                'Update new inspection',
                $request->user()->id,
            );
            // Commit Transaction
            DB::commit();
        } catch (Throwable $exceptions) {
            DB::rollBack();
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Response
        return $this->response;
    }

    /**
     * Delete a category by UUID.
     *
     * @param  string  $uuid  The UUID of the category to delete.
     * @return array The response indicating the result of the deletion.
     *
     * @throws \Exception If there is an error deleting the category.
     */
    public function delete(string $uuid): array
    {
        try {
            // Control Transaction
            DB::beginTransaction();
            // Delete Register
            InspectionEquipment::where('inspection_equipment_uuid', $uuid)
                ->update([
                    'deleted_at' => now(),
                ]);
            // Set Response
            $this->response['message'] = trans('api.deleted');
            // Commit Transaction
            DB::commit();
        } catch (Throwable $exceptions) {
            DB::rollBack();
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Response
        return $this->response;
    }

    /**
     * Retrieve a specific category.
     *
     * @param  string  $uuid  The UUID of the category to retrieve.
     * @return array The response containing the category.
     *
     * @throws \Exception If there is an error retrieving the category.
     */
    public function show(string $uuid): array
    {
        try {
            $this->response['message'] = trans('api.show');
            $inspectionEquipment = InspectionEquipment::with(['equipment'])
                ->where([
                    'inspection_equipment_uuid' => $uuid,
                ])->first();
            $this->response['data'] = $inspectionEquipment;
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        return $this->response;
    }
}
