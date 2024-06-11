<?php

namespace App\Http\Controllers\Api\V1\Projects;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Projects\EmployeeRequest;
use App\Http\Requests\Api\Projects\ProjectsRequest;
use App\Services\Api\V1\Projects\EmployeeService;
use App\Services\Api\V1\Projects\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class EmployeeController extends Controller
{
    protected EmployeeService $service;

    /**
     * Constructor for the class.
     */
    public function __construct()
    {
        $this->service = new EmployeeService();
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
     */
    public function store(EmployeeRequest $request): JsonResponse
    {
        $this->service->create($request);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid): JsonResponse
    {
        $request = (['project_employee_uuid' => $uuid]);

        if (! $this->commonValidation($request)) {
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
        $request->merge(['project_employee_uuid' => $uuid]);
        $validated = Validator::make($request->all(), [
            'project_employee_uuid' => 'required|uuid|exists:project_employees,project_employee_uuid',
            'project_uuid' => 'required|uuid|exists:projects,project_uuid',
            'employee_uuid' => 'required|uuid|exists:users,uuid',
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
        $request = ['project_employee_uuid' => $uuid];

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
            'project_employee_uuid' => 'required|uuid|exists:project_employees,project_employee_uuid',
        ]);

        if ($validated->fails()) {
            $this->service->setFailValidation($validated->errors());

            return false;
        }

        return true;
    }
}
