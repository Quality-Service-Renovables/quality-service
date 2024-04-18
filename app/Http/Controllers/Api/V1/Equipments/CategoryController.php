<?php

namespace App\Http\Controllers\Api\V1\Equipments;

use App\Http\Controllers\Controller;
use App\Http\Modules\Api\V1\Equipments\CategoryModule;
use App\Http\Requests\Api\Equipments\CategoryRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    protected CategoryModule $module;

    /**
     * Constructor for the class.
     */
    public function __construct()
    {
        $this->module = new CategoryModule();
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
    public function create(CategoryRequest $request): JsonResponse
    {
        $this->module->create($request);

        return response()->json($this->module->response, $this->module->statusCode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        $this->module->create($request);

        return response()->json($this->module->response, $this->module->statusCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid): JsonResponse
    {
        $request = (['equipment_category_uuid' => $uuid]);

        $validated = Validator::make($request, [
            'equipment_category_uuid' => 'required|uuid|exists:equipment_categories,equipment_category_uuid',
        ]);

        if ($validated->fails()) {
            $this->module->statusCode = 400;
            $this->module->response['status'] = 'fail';
            $this->module->response['message'] = $validated->errors();

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
        $this->module->read();

        return response()->json($this->module->response, $this->module->statusCode);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uuid): JsonResponse
    {
        $request->merge(['equipment_category_uuid' => $uuid]);

        $validated = Validator::make($request->all(), [
            'equipment_category_uuid' => 'required|uuid|exists:equipment_categories,equipment_category_uuid',
            'equipment_category' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('equipment_categories', 'equipment_category')
                    ->whereNot('equipment_category_uuid', $uuid)
                    ->whereNull('deleted_at'),
            ],
            'description' => 'required|string|min:3|max:255',
            'active' => 'required|bool',
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
        $request = ['equipment_category_uuid' => $uuid];

        $validated = Validator::make($request, [
            'equipment_category_uuid' => 'required|uuid|exists:equipment_categories,equipment_category_uuid',
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

    /**
     * Render the equipment component.
     */
    public function component(): Response
    {
        $this->module->read();

        return Inertia::render('EquipmentCategories', [
            'equipment_categories' => $this->module->response['data'],
        ]);
    }
}
