<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Inspections;

use App\Models\Inspections\Category;
use App\Services\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
            // Complement Request
            $data = $request->all();
            $data['ct_inspection_uuid'] = Str::uuid()->toString();
            $data['ct_inspection_code'] = create_slug($request->get('ct_inspection'));
            // Create Register
            Category::create($data);
            // Recover Register
            $category = Category::where('ct_inspection_uuid', $data['ct_inspection_uuid'])->first();
            // Set Response
            $this->statusCode = 201;
            $this->response['message'] = 'Category created';
            $this->response['data'] = ['category' => $category];
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
        } catch (Exception $exception) {
            DB::rollBack();
            $this->response['status'] = 'error';
            $this->statusCode = 500;
            $this->response['message'] = 'Unable to get list of categories' . $exception->getMessage();
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
            $this->response['message'] = 'List of Categories';
            $this->response['data'] = ['categories' => Category::whereNull('deleted_at')->get()];
        } catch (Exception $exception) {
            $this->response['status'] = 'error';
            $this->response['message'] = 'Unable to get list of categories: ' . $exception->getMessage();
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
            // Complement Request
            $data = $request->all();
            $data['ct_inspection_code'] = create_slug($request->get('ct_inspection'));
            // Create Register
            Category::where('ct_inspection_uuid', $request->ct_inspection_uuid)
                ->update($data);
            // Recover Register
            $category = Category::where('ct_inspection_uuid', $request->ct_inspection_uuid)->first();
            // Set Response
            $this->response['message'] = 'Category updated';
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
        } catch (Exception $exception) {
            DB::rollBack();
            $this->response['status'] = 'error';
            $this->statusCode = 500;
            $this->response['message'] = 'Unable update category: ' . $exception->getMessage();
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
            $this->response['message'] = 'Category deleted';
            // Commit Transaction
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            $this->response['status'] = 'error';
            $this->statusCode = 500;
            $this->response['message'] = 'Unable delete category: ' . $exception->getMessage();
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
            $this->response['message'] = 'Show Category';
            $category = Category::where([
                'ct_inspection_uuid' => $uuid,
                'deleted_at' => null,
            ])->first();
            $this->response['data'] = compact('category');
        } catch (Exception $exception) {
            $this->response['status'] = 'error';
            $this->response['message'] = 'Unable to show category: ' . $exception->getMessage();
        }

        return $this->response;
    }
}
