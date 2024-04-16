<?php

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Http\Modules\Api\V1\Inspections;

use App\Http\Modules\MainModule;
use App\Models\InspectionCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryModule extends MainModule
{
    public string $nameModule = 'inspection_category';

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
            // Complement Request
            $data = $request->all();
            $data['inspection_category_uuid'] = Str::uuid()->toString();
            $data['inspection_category_code'] = create_slug($request->get('inspection_category'));
            // Create Register
            InspectionCategory::create($data);
            // Recover Register
            $category = InspectionCategory::where('inspection_category_uuid', $data['inspection_category_uuid'])->first();
            // Set Response
            $this->response['statusCode'] = 201;
            $this->response['message'] = 'Category created';
            $this->response['data'] = ['category' => $category];
            // Set Log
            $this->logModule->create(
                $this->nameModule,
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
            $this->response['statusCode'] = 500;
            $this->response['message'] = 'Unable to get list of categories'.$exception->getMessage();
        }

        // Response
        return $this->response;
    }

    public function update(Request $request): array
    {
        try {
            // Control Transaction
            DB::beginTransaction();
            // Complement Request
            $data = $request->all();
            $data['inspection_category_code'] = create_slug($request->get('inspection_category'));
            // Create Register
            InspectionCategory::where('inspection_category_uuid', $request->inspection_category_uuid)
                ->update($data);
            // Recover Register
            $category = InspectionCategory::where('inspection_category_uuid', $request->inspection_category_uuid)->first();
            // Set Response
            $this->response['message'] = 'Category updated';
            $this->response['data'] = ['category' => $category];
            // Set Log
            $this->logModule->create(
                $this->nameModule,
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
            $this->response['statusCode'] = 500;
            $this->response['message'] = 'Unable update category: '.$exception->getMessage();
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
            $this->response['data'] = ['categories' => InspectionCategory::whereNull('deleted_at')->get()];
        } catch (Exception $exception) {
            $this->response['status'] = 'error';
            $this->response['message'] = 'Unable to get list of categories: '.$exception->getMessage();
        }

        return $this->response;
    }

    public function delete(string $uuid): array
    {
        try {
            // Control Transaction
            DB::beginTransaction();
            // Delete Register
            InspectionCategory::where('inspection_category_uuid', $uuid)
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
            $this->response['statusCode'] = 500;
            $this->response['message'] = 'Unable delete category: '.$exception->getMessage();
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
            $this->response['message'] = 'Show Category';
            $category = InspectionCategory::where([
                'inspection_category_uuid' => $uuid,
                'deleted_at' => null
            ])->first();
            $this->response['data'] = compact('category');
        } catch (Exception $exception) {
            $this->response['status'] = 'error';
            $this->response['message'] = 'Unable to show category: '.$exception->getMessage();
        }

        return $this->response;
    }
}
