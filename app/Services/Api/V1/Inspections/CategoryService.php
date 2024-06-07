<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Inspections;

use App\Models\Inspections\Category;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class CategoryService extends Service
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
            $category = Category::create($request->all());
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
            $this->response['data'] = Category::all();
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
            $category = Category::where('ct_inspection_uuid', $request->ct_inspection_uuid)->first();
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
            Category::where('ct_inspection_uuid', $uuid)
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
            $category = Category::where([
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
