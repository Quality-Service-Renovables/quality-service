<?php

namespace App\Http\Controllers\Api\V1\Equipments;

use App\Http\Controllers\Controller;
use App\Http\Modules\Api\V1\Equipments\EquipmentModule;
use App\Http\Requests\Api\Equipments\EquipmentRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

        return response()->json($this->module->response, $this->module->status_code);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(EquipmentRequest $request): JsonResponse
    {
        $this->module->create($request);

        return response()->json($this->module->response, $this->module->status_code);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EquipmentRequest $request): JsonResponse
    {
        $this->module->create($request);

        return response()->json($this->module->response, $this->module->status_code);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $this->module->read();

        return response()->json($this->module->response, $this->module->status_code);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): JsonResponse
    {
        $this->module->read();

        return response()->json($this->module->response, $this->module->status_code);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $this->module->read();

        return response()->json($this->module->response, $this->module->status_code);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $this->module->read();

        return response()->json($this->module->response, $this->module->status_code);
    }

    public function component(): Response
    {
        $this->module->read();

        return Inertia::render('Equipment', [
            'equipments' => $this->module->response['data'],
        ]);
    }
}
