<?php

namespace App\Http\Controllers\Api\V1\Status;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Status\StatusRequest;
use App\Services\Api\V1\Status\StatusService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class StatusController extends Controller
{
    protected StatusService $service;

    /**
     * Constructor for the class.
     */
    public function __construct()
    {
        $this->service = new StatusService();
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
    public function create(Request $request): JsonResponse
    {
        $this->service->create($request);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StatusRequest $request): JsonResponse
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
     *
     * @throws \Exception
     */
    public function update(Request $request, string $uuid): JsonResponse
    {
        $request->merge(['status_uuid' => $uuid]);
        $validated = Validator::make($request->all(), [
            'status_uuid' => 'required|string|exists:status,status_uuid',
            'status' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('status', 'status')
                    ->whereNot('status_uuid', $uuid)
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
    private function commonValidation(string $uuid): bool
    {
        $request = (['status_uuid' => $uuid]);

        $validated = Validator::make($request, [
            'status_uuid' => 'required|uuid|exists:status,status_uuid',
        ]);

        if ($validated->fails()) {
            $this->service->setFailValidation($validated->errors());

            return false;
        }

        return true;
    }
}
