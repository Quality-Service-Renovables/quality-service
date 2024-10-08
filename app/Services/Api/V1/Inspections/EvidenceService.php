<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Inspections;

use App\Models\Inspections\Evidence;
use App\Models\Inspections\Inspection;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class EvidenceService extends Service
{
    public string $nameService = 'inspection_equipment';

    public function create(Request $request): array
    {
        try {
            // Control Transaction
            DB::beginTransaction();
            $inspection = Inspection::where('inspection_uuid', $request->inspection_uuid)->first();

            $request->merge([
                'inspection_evidence_uuid' => Str::uuid()->toString(),
                'inspection_id' => $inspection->inspection_id,
            ]);

            $this->storeFile($request,
                'evidence_store',
                'evidences',
                'inspection_evidence'
            );

            if ($request->evidence_store_secondary) {
                $this->storeFile($request,
                    'evidence_store_secondary',
                    'evidences',
                    'inspection_evidence_secondary'
                );
            }
            // En caso de que la solicitud provenga de la aplicación móvil, se eliminan todas las evidencias asociadas al mismo campo e inspección
            if ($request->has('from') && $request->from === 'app') {
                Evidence::where('inspection_form_id', $request->inspection_form_id)
                    ->where('inspection_id', $inspection->inspection_id)
                    ->whereNotNull("sync_app_uuid")
                    ->where("sync_app_uuid", "!=", $request->sync_app_uuid)
                    ->delete();
            }

            // Create Register
            $inspectionEquipment = Evidence::create($request->all());
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
            $this->response['data'] = Evidence::with(['inspection'])->get();
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        return $this->response;
    }

    /**
     * Update a category.
     *
     * @param \Illuminate\Http\Request $request The request data.
     *
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

            $request->merge([
                'inspection_id' => $inspection->inspection_id,
            ]);

            // En caso de que se actualicen las evidencias y existan registros previos se depuran.
            if ($inspection->envidence_store !== $request->inspection_store) {
                $this->purgeFile($inspection->inspection_evidence_secondary);
                if ($inspection->evidence_store_secondary) {
                    $this->purgeFile($inspection->inspection_evidence_secondary);
                }
            }
            // Se registra la evidencia principal y secundaria
            if ($request->evidence_store) {
                $this->storeFile($request,
                    'evidence_store',
                    'evidences',
                    'inspection_evidence'
                );
            }

            if ($request->evidence_store_secondary) {
                $this->storeFile($request,
                    'evidence_store_secondary',
                    'evidences',
                    'inspection_evidence_secondary'
                );
            }

            // Update Register
            $inspectionEvidence = Evidence::with(['inspection'])
                ->where('inspection_evidence_uuid', $request->inspection_evidence_uuid)
                ->first();
            // Si el $category existe (no es nulo), actualízalo con todos los datos de la solicitud.
            $inspectionEvidence?->update($request->all());
            // Set Response
            $this->response['message'] = trans('api.updated');
            $this->response['data'] = $inspectionEvidence;
            // Set Log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                'Update new evidence inspection',
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
     * @param string $uuid The UUID of the category to delete.
     *
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
            Evidence::where('inspection_evidence_uuid', $uuid)
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
     * @param string $uuid The UUID of the category to retrieve.
     *
     * @return array The response containing the category.
     *
     * @throws \Exception If there is an error retrieving the category.
     */
    public function show(string $uuid): array
    {
        try {
            $this->response['message'] = trans('api.show');
            $inspectionEvidence = Evidence::with(['inspection'])
                ->where([
                    'inspection_evidence_uuid' => $uuid,
                ])->first();
            $this->response['data'] = $inspectionEvidence;
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        return $this->response;
    }

    /**
     * Update evidence positions.
     *
     * @param \Illuminate\Http\Request $request The request data.
     *
     * @return array The response containing the updated category.
     *
     * @throws \Exception If there is an error updating the category.
     */
    public function positions(Request $request): array
    {
        try {
            // Control Transaction
            DB::beginTransaction();
            $evidences = [];
            foreach ($request->evidences as $evidence) {
                $inspectionEvidence = Evidence::where([
                    'inspection_evidence_uuid' => $evidence['inspection_evidence_uuid'],
                ])->first();
                $inspectionEvidence->update([
                    'position' => $evidence['position'],
                ]);
                $evidences[] = $evidence;
            }
            $this->response['message'] = trans('api.updated');
            $this->response['data'] = $evidences;
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
}
