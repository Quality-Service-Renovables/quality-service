<?php

namespace App\Http\Controllers\Api\V1\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Clients\ClientRequest;
use App\Services\Api\V1\Clients\ClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class ClientController extends Controller
{
    protected ClientService $service;

    /**
     * Constructor for the class.
     */
    public function __construct()
    {
        $this->service = new ClientService();
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
    public function create(ClientRequest $request): JsonResponse
    {
        $this->service->create($request);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request): JsonResponse
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
        $request->merge(['client_uuid' => $uuid]);

        $validated = Validator::make($request->all(), [
            'client_uuid' => 'required|uuid|exists:clients,client_uuid',
            'client' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('clients', 'client')
                    ->whereNot('client_uuid', $request->client_uuid)
                    ->whereNull('deleted_at'),
            ],
            'logo' => 'nullable|string',
            'logo_store' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'legal_name' => 'nullable|string',
            'address' => 'nullable|string',
            'zipcode' => 'nullable|string',
            'phone' => [
                'nullable',
                'regex:/^(\+\d{1,3}[- ]?)?\d{10}$/',
            ],
            'phone_office' => [
                'nullable',
                'regex:/^(\+\d{1,3}[- ]?)?\d{10}$/',
            ],
            'open_time' => 'nullable|date_format:H:i',
            'close_time' => 'nullable|date_format:H:i',
            'office_days' => 'nullable|string',
            'website' => 'nullable|url',
            'email' => [
                'required',
                'email',
                'min:1',
                'max:255',
                Rule::unique('clients', 'email')
                    ->whereNot('client_uuid', $request->client_uuid)
                    ->whereNull('deleted_at'),
            ],
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

        return Inertia::render('Customer', [
            'customers' => $this->service->response['data'],
        ]);
    }

    /**
     * Perform common validation for a given UUID.
     *
     * @param string $uuid
     *
     * @return bool
     */
    private function commonValidation(string $uuid): bool
    {
        $request = (['client_uuid' => $uuid]);
        $validated = Validator::make($request, [
            'client_uuid' => 'required|uuid|exists:clients,client_uuid',
        ]);

        if ($validated->fails()) {
            $this->service->setFailValidation($validated->errors());

            return false;
        }

        return true;
    }
}
