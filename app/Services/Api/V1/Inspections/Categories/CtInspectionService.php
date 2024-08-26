<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Inspections\Categories;

use Throwable;
use App\Services\Service;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Inspections\Inspection;
use App\Models\Inspections\Categories\CtInspection;

class CtInspectionService extends Service
{
    public string $nameService = 'ct_inspection';

    /**
     * Create a new category.
     *
     * @param \Illuminate\Http\Request $request The request object.
     *
     * @return array The response containing the created category.
     */
    public function create(Request $request): array
    {
        try {
            // Control Transaction
            DB::beginTransaction();
            $request->merge([
                'ct_inspection_uuid' => Str::uuid()->toString(),
                'ct_inspection_code' => create_slug($request->ct_inspection),
            ]);
            // Create Register
            $category = CtInspection::create($request->all());
            // Set Response
            $this->statusCode = 201;
            $this->response['message'] = trans('api.created');
            $this->response['data'] = $category;
            // Set Log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                'Create new category inspection',
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
            $ctInspections = CtInspection::all();

            foreach ($ctInspections as $value) {
                $isThereAnInspectionInProcess = Inspection::where('ct_inspection_id', $value->ct_inspection_id)
                    ->where('inspection_in_process', 1)
                    ->where('deleted_at', null)
                    ->exists();
                
                $value->inspection_in_process = $isThereAnInspectionInProcess;
            }

            $this->response['data'] = $ctInspections;
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

            $request->merge([
                'ct_inspection_code' => create_slug($request->get('ct_inspection')),
            ]);
            // Update Register
            $category = CtInspection::where('ct_inspection_uuid', $request->ct_inspection_uuid)->first();
            // Si el $category existe (no es nulo), actualízalo con todos los datos de la solicitud.
            $category?->update($request->all());
            // Set Response
            $this->response['message'] = trans('api.updated');
            $this->response['data'] = $category;
            // Set Log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                'Update new category inspection',
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
            CtInspection::where('ct_inspection_uuid', $uuid)
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
            $category = CtInspection::where([
                'ct_inspection_uuid' => $uuid,
                'deleted_at' => null,
            ])->first();
            $this->response['data'] = $category;
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        return $this->response;
    }
}
