<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Inspections;

use App\Models\Inspections\Category;
use App\Models\Inspections\Inspection;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InspectionService extends Service
{
    public string $nameService = 'inspection';

    /**
     * Create a new category.
     *
     * @param  \Illuminate\Http\Request  $request  The request object.
     * @return array The response containing the created category.
     */
    public function create(Request $request): array
    {
        try {
            // Control Transaction
            DB::beginTransaction();
            $category = Category::where('ct_inspection_code', $request->ct_inspection_code)->first();
            // Establecer atributos para registro
            $request->merge([
                'inspection_uuid' => Str::uuid()->toString(),
                'ct_inspection_id' => $category->ct_inspection_id,
            ]);
            // Create Register
            $inspection = Inspection::create($request->all());
            // Set Response
            $this->statusCode = 201;
            $this->response['message'] = trans('api.created');
            $this->response['data'] = $inspection;
            // Set Log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                'Create new inspection',
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
            $this->response['message'] = trans('api.readed');
            $this->response['data'] = ['inspections' => Inspection::with(['category'])->get()];
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

            $request->merge([
                'inspection_code' => create_slug($request->inspection),
            ]);
            // Update Register
            $category = Inspection::where('inspection_uuid', $request->inspection_uuid)->first();
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
            Inspection::where('inspection_uuid', $uuid)
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
            $inspection = Inspection::with([
                'equipments.equipment',
                'forms',
                'evidences',
            ])
                ->where([
                    'inspection_uuid' => $uuid,
                    'deleted_at' => null,
                ])->first();
            $this->response['data'] = compact('inspection');
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        return $this->response;
    }
}
