<?php

namespace App\Http\Controllers\Api\V1\Equipments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Equipments\EquipmentRequest;
use App\Services\Api\V1\Equipments\EquipmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class EquipmentController extends Controller
{
    protected EquipmentService $service;

    /**
     * Constructor for the class.
     */
    public function __construct()
    {
        $this->service = new EquipmentService();
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
     * Show the form for creating a new resource.
     */
    public function create(EquipmentRequest $request): JsonResponse
    {
        $this->service->create($request);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EquipmentRequest $request): JsonResponse
    {
        $this->service->create($request);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid): JsonResponse
    {
        $request = (['equipment_uuid' => $uuid]);

        if (!$this->commonValidation($request)) {
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
        $this->service->read();

        $this->service->response['message'] = 'Api edit request not available: ' . $uuid;

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uuid): JsonResponse
    {
        $request->merge(['equipment_uuid' => $uuid]);

        $validated = Validator::make($request->all(), [
            'equipment_uuid' => 'required|uuid|exists:equipments,equipment_uuid',
            'equipment' => 'required|string',
            'equipment_category_code' => 'required|string|exists:equipment_categories,equipment_category_code',
            'trademark_code' => 'required|string|exists:trademarks,trademark_code',
            'trademark_model_code' => 'required|string|exists:trademark_models,trademark_model_code',
            'status_code' => 'required|string|exists:status,status_code',
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
        $request = ['equipment_uuid' => $uuid];

        if (!$this->commonValidation($request)) {
            return response()->json($this->service->response, $this->service->statusCode);
        }

        $this->service->delete($uuid);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Render the equipment component.
     *
     * @return \Inertia\Response
     */
    public function component(): Response
    {
        $this->service->read();

        return Inertia::render('Equipment', [
            'equipments' => $this->service->response['data'],
        ]);
    }

    /**
     * Perform common validation for the request data.
     *
     *
     * @return bool Returns true if validation passes, false otherwise.
     */
    private function commonValidation(array $request): bool
    {
        $validated = Validator::make($request, [
            'equipment_uuid' => 'required|uuid|exists:equipments,equipment_uuid',
        ]);

        if ($validated->fails()) {
            $this->service->setFailValidation($validated->errors());

            return false;
        }

        return true;
    }
}
