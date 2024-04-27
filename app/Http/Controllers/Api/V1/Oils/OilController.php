<?php

namespace App\Http\Controllers\Api\V1\Oils;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Oils\OilRequest;
use App\Services\Api\V1\OIls\OilService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class OilController extends Controller
{
    protected OilService $service;

    /**
     * Constructor for the class.
     */
    public function __construct()
    {
        $this->service = new OilService();
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
    public function create(OilRequest $request): JsonResponse
    {
        $this->service->create($request);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OilRequest $request): JsonResponse
    {
        $this->service->create($request);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid): JsonResponse
    {
        if (! $this->commonValidation($uuid)) {
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

        $this->service->response['message'] = 'Api edit request not available: '.$uuid;

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uuid): JsonResponse
    {
        $request->merge(['oil_uuid' => $uuid]);

        $validated = Validator::make($request->all(), [
            'oil_uuid' => 'required|uuid|exists:oils,oil_uuid',
            'oil' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('oils', 'oil')
                    ->whereNot('oil_uuid', $uuid)
                    ->whereNull('deleted_at'),
            ],
            'viscosity' => 'nullable|string',
            'description' => 'required|string',
            'oil_category_code' => 'required|string|exists:oil_categories,oil_category_code',
            'trademark_code' => 'required|string|exists:trademarks,trademark_code',
            'trademark_model_code' => 'required|string|exists:trademark_models,trademark_model_code',
            'production_date' => 'nullable|date',
            'expiration_date' => 'nullable|date',
            'quantity' => 'nullable|integer',
            'active' => 'nullable|boolean',
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
        if (! $this->commonValidation($uuid)) {
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

        return Inertia::render('Oil', [
            'oils' => $this->service->response['data'],
        ]);
    }

    /**
     * Perform common validation for a given UUID.
     *
     * @param  string  $uuid  The UUID to validate.
     * @return bool True if the validation passes, false otherwise.
     */
    private function commonValidation(string $uuid): bool
    {
        $request = (['oil_uuid' => $uuid]);

        $validated = Validator::make($request, [
            'oil_uuid' => 'required|uuid|exists:oils,oil_uuid',
        ]);

        if ($validated->fails()) {
            $this->service->setFailValidation($validated->errors());

            return false;
        }

        return true;
    }
}
