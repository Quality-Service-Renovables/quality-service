<?php

namespace App\Http\Controllers\Api\V1\Equipments;

use App\Http\Controllers\Controller;
use App\Http\Modules\Api\V1\Equipments\EquipmentModule;
use App\Http\Requests\Api\Equipments\EquipmentRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class EquipmentController extends Controller
{
    protected EquipmentModule $module;

    public function __construct()
    {
        $this->module = new EquipmentModule();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $this->module->read();

        return response()->json($this->module->response, $this->module->statusCode);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(EquipmentRequest $request): JsonResponse
    {
        $this->module->create($request);

        return response()->json($this->module->response, $this->module->statusCode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EquipmentRequest $request): JsonResponse
    {
        $this->module->create($request);

        return response()->json($this->module->response, $this->module->statusCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $this->module->read();

        return response()->json($this->module->response, $this->module->statusCode);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): JsonResponse
    {
        $this->module->read();

        return response()->json($this->module->response, $this->module->statusCode);
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
            'status_code' => 'required|string|exists:status,status_code',
        ]);

        if ($validated->fails()) {
            $this->module->statusCode = 400;
            $this->module->response['status'] = 'fail';
            $this->module->response['message'] = $validated->errors();
            return response()->json($this->module->response, $this->module->statusCode);
        }

        $this->module->update($request);

        return response()->json($this->module->response, $this->module->statusCode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid): JsonResponse
    {
        $request = ['equipment_uuid' => $uuid];

        $validated = Validator::make($request, [
            'equipment_uuid' => 'required|uuid|exists:equipments,equipment_uuid',
        ]);

        if ($validated->fails()) {
            $this->module->statusCode = 400;
            $this->module->response['status'] = 'fail';
            $this->module->response['message'] = $validated->errors();
            return response()->json($this->module->response, $this->module->statusCode);
        }

        $this->module->delete($uuid);

        return response()->json($this->module->response, $this->module->statusCode);
    }

    public function component(): Response
    {
        $this->module->read();

        return Inertia::render('Equipment', [
            'equipments' => $this->module->response['data'],
        ]);
    }
}
