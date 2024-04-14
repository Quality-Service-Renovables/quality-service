<?php

namespace App\Http\Controllers\Api\V1\Inspections;

use App\Http\Controllers\Controller;
use App\Http\Modules\Api\V1\Inspections\CategoryModule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    protected CategoryModule $module;

    public function __construct()
    {
        $this->module = new CategoryModule();
    }

    /**
     * Display a listing of the resource.
     *
     * @throws \Exception
     */
    public function index(): JsonResponse
    {
        $this->module->read();

        return response()->json($this->module->response, $this->module->statusCode);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): JsonResponse
    {
        return response()->json($this->module->response, $this->module->statusCode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'inspection_category' => 'required|string|min:10|max:255|unique:inspection_categories,inspection_category,NULL,inspection_category_uuid,deleted_at,NULL',
            'description' => 'required|string|min:10|max:255',
        ]);

        if ($validation->fails()) {
            $this->module->response = [
                'message' => 'Validation error',
                'errors' => $validation->errors(),
            ];
            $this->module->statusCode = 422;

            return response()->json($this->module->response, $this->module->statusCode);
        }

        $this->module->create($request);

        return response()->json($this->module->response, $this->module->statusCode);
    }

    /**
     * Display the specified resource.
     *
     * @throws \Exception
     */
    public function show(string $uuid): JsonResponse
    {
        $request = ['uuid' => $uuid];
        $validation = Validator::make($request, [
            'uuid' => 'required|string|min:10|max:255|exists:inspection_categories,inspection_category_uuid',
        ]);

        if ($validation->fails()) {
            $this->module->response = [
                'message' => 'Validation error',
                'errors' => $validation->errors(),
            ];
            $this->module->statusCode = 422;

            return response()->json($this->module->response, $this->module->statusCode);
        }

        $this->module->show($uuid);

        return response()->json($this->module->response, $this->module->statusCode);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid): JsonResponse
    {
        return response()->json($this->module->response, $this->module->statusCode);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uuid): JsonResponse
    {
        // Add elements to request
        $request->request->add(['inspection_category_uuid' => $uuid]);
        // Validate
        $validation = Validator::make($request->all(), [
            'inspection_category_uuid' => 'required|string|min:10|max:255|exists:inspection_categories,inspection_category_uuid',
            'inspection_category' => 'required|string|min:10|max:255|unique:inspection_categories,inspection_category,' . $request->inspection_category_uuid . ',inspection_category_uuid',
            'description' => 'required|string|min:10|max:255',
        ]);

        // Validation fails
        if ($validation->fails()) {
            $this->module->response = [
                'message' => 'Validation error',
                'errors' => $validation->errors(),
            ];
            $this->module->statusCode = 422;

            return response()->json($this->module->response, $this->module->statusCode);
        }
        // Module Processs
        $this->module->update($request);
        // Module Response
        return response()->json($this->module->response, $this->module->statusCode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid): JsonResponse
    {
        $request = ['inspection_category_uuid' => $uuid];
        $validation = Validator::make($request, [
            'inspection_category_uuid' => 'required|string|min:10|max:255|exists:inspection_categories,inspection_category_uuid',
        ]);

        if ($validation->fails()) {
            $this->module->response = [
                'message' => 'Validation error',
                'errors' => $validation->errors(),
            ];
            $this->module->statusCode = 422;

            return response()->json($this->module->response, $this->module->statusCode);
        }

        $this->module->delete($uuid);

        return response()->json($this->module->response, $this->module->statusCode);
    }
}
