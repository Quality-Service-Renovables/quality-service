<?php

namespace App\Http\Controllers\Api\V1\Inspections;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Inspections\EquipmentRequest;
use App\Services\Api\V1\Inspections\EquipmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EquipmentController extends Controller
{
    protected EquipmentService $service;

    /**
     * EquipmentController constructor.
     *
     * Initializes an instance of the EquipmentController class.
     * Creates an instance of the EquipmentService class and assigns it to the $service property.
     *
     * @return void
     */
    public function __construct()
    {
        $this->service = new EquipmentService();
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
     *
     * @throws \Exception
     */
    public function show(string $uuid): JsonResponse
    {
        $request = (['inspection_equipment_uuid' => $uuid]);

        if (! $this->commonValidation($request)) {
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
        $this->service->response['message'] = 'Api edit request not available: '.$uuid;

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws \Exception
     */
    public function update(Request $request, string $uuid): JsonResponse
    {
        $request->merge(['inspection_equipment_uuid' => $uuid]);
        $validated = Validator::make($request->all(), [
            'inspection_equipment_uuid' => 'required|uuid|exists:inspection_equipments,inspection_equipment_uuid',
            'equipments.*.equipment_uuid' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::exists('equipments', 'equipment_uuid')
                    ->whereNull('deleted_at'),
            ],
            'inspection_uuid' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::exists('inspections', 'inspection_uuid')
                    ->whereNull('deleted_at'),
            ],
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
     *
     * @throws \Exception
     */
    public function destroy(string $uuid): JsonResponse
    {
        $request = ['inspection_equipment_uuid' => $uuid];

        if (! $this->commonValidation($request)) {
            return response()->json($this->service->response, $this->service->statusCode);
        }

        $this->service->delete($uuid);

        return response()->json($this->service->response, $this->service->statusCode);
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
            'inspection_equipment_uuid' => 'required|uuid|exists:inspection_equipments,inspection_equipment_uuid',
        ]);

        if ($validated->fails()) {
            $this->service->setFailValidation($validated->errors());

            return false;
        }

        return true;
    }
}
