<?php

namespace App\Http\Controllers\Api\V1\Inspections;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\Api\V1\Inspections\CategoryService;
use App\Http\Requests\Api\Inspections\CategoryRequest;
use Inertia\Response;

class CategoryController extends Controller
{
    protected CategoryService $service;

    public function __construct()
    {
        $this->service = new CategoryService();
    }

    /**
     * Display a listing of the resource.
     *
     * @throws \Exception
     */
    public function index(): JsonResponse
    {
        $this->service->read();

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): JsonResponse
    {
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
     *
     * @throws \Exception
     */
    public function show(string $uuid): JsonResponse
    {
        if (!$this->commonValidation($uuid)) {
            return response()->json($this->service->response, $this->service->statusCode);
        }

        $this->service->show($uuid);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid): JsonResponse
    {
        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws \Exception
     */
    public function update(Request $request, string $uuid): JsonResponse
    {
        // Add elements to request
        $request->request->add(['ct_inspection_uuid' => $uuid]);
        // Validate
        $validation = Validator::make($request->all(), [
            'ct_inspection_uuid' => 'required|string|min:10|max:255|exists:ct_inspections,ct_inspection_uuid',
            'ct_inspection' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('ct_inspections', 'ct_inspection')
                    ->whereNot('ct_inspection_uuid', $uuid)
                    ->whereNull('deleted_at'),
            ],
            'description' => 'required|string|min:10|max:255',
        ]);

        // Validation fails
        if ($validation->fails()) {
            $this->service->response = [
                'message' => 'Validation error',
                'errors' => $validation->errors(),
            ];
            $this->service->statusCode = 422;

            return response()->json($this->service->response, $this->service->statusCode);
        }
        // service Processs
        $this->service->update($request);

        // service Response
        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \Exception
     */
    public function destroy(string $uuid): JsonResponse
    {
        if (!$this->commonValidation($uuid)) {
            return response()->json($this->service->response, $this->service->statusCode);
        }

        $this->service->delete($uuid);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Render the project component.
     */
    public function component(): Response
    {
        $this->service->read();

        return Inertia::render('Inspections', [
            'ct_inspections' => $this->service->response['data'],
        ]);
    }

    /**
     * Perform common validation for the given UUID.
     *
     * @param string $uuid The UUID to validate.
     *
     * @return bool True if the validation passes, false otherwise.
     */
    private function commonValidation(string $uuid): bool
    {
        $request = ['ct_inspection_uuid' => $uuid];

        $validated = Validator::make($request, [
            'ct_inspection_uuid' => 'required|string|min:10|max:255|exists:ct_inspections,ct_inspection_uuid',
        ]);

        if ($validated->fails()) {
            $this->service->setFailValidation($validated->errors());

            return false;
        }

        return true;
    }
}
