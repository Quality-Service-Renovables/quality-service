<?php

namespace App\Http\Controllers\Api\V1\AuthGuards;

use App\Http\Controllers\Controller;
use App\Services\Api\V1\AuthGuards\RolPermissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class RolePermissionController extends Controller
{
    protected RolPermissionService $service;

    /**
     * Constructor for the class.
     */
    public function __construct()
    {
        $this->service = new RolPermissionService();
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
     * Update a resource in storage.
     *
     * @param Request $request
     * @param string  $id
     *
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $request->merge(['id' => $id]);
        $validated = Validator::make($request->all(), [
            'id' => 'required|exists:roles,id',
            'name' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('roles', 'name')
                    ->whereNot('id', $id),
            ],
            'permissions' => 'required|array',
        ]);

        if ($validated->fails()) {
            $this->service->setFailValidation($validated->errors());
            return response()->json($this->service->response, $this->service->statusCode);
        }

        $this->service->update($request);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Render the equipment component.
     */
    public function component(): Response
    {
        $this->service->read();

        return Inertia::render('RolesAndPermissions/index', [
            'roles-permissions' => $this->service->response['data'],
        ]);
    }
}
