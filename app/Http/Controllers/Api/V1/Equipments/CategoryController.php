<?php

namespace App\Http\Controllers\Api\V1\Equipments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Equipments\CategoryRequest;
use App\Http\Requests\Api\Trademarks\TrademarkRequest;
use App\Services\Api\V1\Equipments\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

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
     * Show the form for creating a new resource.
     */
    public function create(TrademarkRequest $request): JsonResponse
    {
        $this->service->create($request);

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
        $request = (['ct_equipment_uuid' => $uuid]);

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
        $request->merge(['ct_equipment_uuid' => $uuid]);

        $validated = Validator::make($request->all(), [
            'ct_equipment_uuid' => 'required|uuid|exists:ct_equipments,ct_equipment_uuid',
            'ct_equipment' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('ct_equipments', 'ct_equipment')
                    ->whereNot('ct_equipment_uuid', $uuid)
                    ->whereNull('deleted_at'),
            ],
            'description' => 'required|string|min:3|max:255',
            'active' => 'required|bool',
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
        $request = ['ct_equipment_uuid' => $uuid];

        if (!$this->commonValidation($request)) {
            return response()->json($this->service->response, $this->service->statusCode);
        }

        $this->service->delete($uuid);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Render the equipment component.
     */
    public function component(): Response
    {
        $this->service->read();

        return Inertia::render('EquipmentCategories', [
            'ct_equipments' => $this->service->response['data'],
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
            'ct_equipment_uuid' => 'required|uuid|exists:ct_equipments,ct_equipment_uuid',
        ]);

        if ($validated->fails()) {
            $this->service->setFailValidation($validated->errors());

            return false;
        }

        return true;
    }
}
