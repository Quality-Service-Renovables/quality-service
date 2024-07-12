<?php

namespace App\Http\Controllers\Api\V1\Failures;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Failures\CategoryRequest;
use App\Services\Api\V1\Failures\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    protected CategoryService $service;

    /**
     * Constructor for the class.
     */
    public function __construct()
    {
        $this->service = new CategoryService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $this->service->read();

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        $this->service->create($request);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid): JsonResponse
    {
        $request = (['ct_failure_uuid' => $uuid]);

        if (!$this->commonValidation($request)) {
            return response()->json($this->service->response, $this->service->statusCode);
        }

        $this->service->show($uuid);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Update a resource in storage.
     */
    public function update(Request $request, string $uuid): JsonResponse
    {
        $request->merge(['ct_failure_uuid' => $uuid]);
        $validated = Validator::make($request->all(), [
            'ct_failure_uuid' => 'required|uuid|exists:ct_failures,ct_failure_uuid',
            'ct_failure' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('failures', 'failure')
                    ->whereNull('deleted_at'),
            ],
            'description' => 'required|string|min:10|max:255',
            'is_default' => 'nullable|boolean',
            'dependency' => 'nullable|integer',
            'active' => 'required|boolean',
        ]);

        if ($validated->fails()) {
            $this->service->setFailValidation($validated->errors());

            return response()->json($this->service->response, $this->service->statusCode);
        }

        $this->service->update($request);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid): JsonResponse
    {
        $request = ['ct_failure_uuid' => $uuid];

        if (!$this->commonValidation($request)) {
            return response()->json($this->service->response, $this->service->statusCode);
        }

        $this->service->delete($uuid);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Perform common validation for the request.
     *
     * @param array $request The request data.
     *
     * @return bool True if the validation passes, false otherwise.
     */
    private function commonValidation(array $request): bool
    {
        $validated = Validator::make($request, [
            'ct_failure_uuid' => 'required|uuid|exists:ct_failures,ct_failure_uuid',
        ]);

        if ($validated->fails()) {
            $this->service->setFailValidation($validated->errors());

            return false;
        }

        return true;
    }
}
