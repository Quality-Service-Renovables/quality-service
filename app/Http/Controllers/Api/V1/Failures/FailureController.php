<?php

namespace App\Http\Controllers\Api\V1\Failures;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Failures\FailureRequest;
use App\Services\Api\V1\Failures\FailureService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class FailureController extends Controller
{
    protected FailureService $service;

    /**
     * Constructor for the class.
     */
    public function __construct()
    {
        $this->service = new FailureService();
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
     * Store a newly created resource in storage.
     *
     * @throws \JsonException
     */
    public function store(FailureRequest $request): JsonResponse
    {
        $this->service->create($request);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Display the specified resource.
     *
     * @throws \Throwable
     */
    public function show(string $uuid): JsonResponse
    {
        $request = (['failure_uuid' => $uuid]);

        if (!$this->commonValidation($request)) {
            return response()->json($this->service->response, $this->service->statusCode);
        }

        $this->service->show($uuid);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Update a resource in storage.
     */
    public function update(Request $request, string $uuid): JsonResponse
    {
        $request->merge(['failure_uuid' => $uuid]);
        $validated = Validator::make($request->all(), [
            'failure_uuid' => 'required|uuid|exists:failures,failure_uuid',
            'failure' => [
                'required',
                'string',
                'min:1',
                'max:255',
                /*Rule::unique('failures', 'failure')
                    ->whereNot('failure_uuid', $uuid)
                    ->whereNull('deleted_at'),*/
            ],
            'description' => 'nullable|string|min:10|max:255',
            'ct_failure_code' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::exists('ct_failures', 'ct_failure_code')
                    ->whereNull('deleted_at'),
            ],
            'active' => 'required|boolean',
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
        $request = ['failure_uuid' => $uuid];

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

        return Inertia::render('Failure', [
            'failures' => $this->service->response['data'],
        ]);
    }

    /**
     * Perform common validation for the request.
     *
     * @param array $request The request data.
     *
     * @return bool True if the validation passes, false otherwise.
     */
    private function commonValidation(array $request): bool
    {
        $validated = Validator::make($request, [
            'failure_uuid' => 'required|uuid|exists:failures,failure_uuid',
        ]);

        if ($validated->fails()) {
            $this->service->setFailValidation($validated->errors());

            return false;
        }

        return true;
    }
}
