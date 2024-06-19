<?php

namespace App\Http\Controllers\Api\V1\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\UserRequest;
use App\Services\Api\V1\Users\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    protected UserService $service;

    public function __construct()
    {
        $this->service = new UserService();
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
    public function create(Request $request)
    {
        dd('thomas');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): JsonResponse
    {
        $this->service->create($request);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uuid): JsonResponse
    {
        $request->merge(['uuid' => $uuid]);
        $validated = Validator::make($request->all(), [
            'uuid' => 'required|uuid|exists:users,uuid',
            'name' => 'required|string',
            'image_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
                    ->whereNot('uuid', $uuid)
                    ->whereNull('deleted_at'),
            ],
            'phone' => 'nullable|alpha_num',
            //'password' => 'nullable|string|min:4|max:12',
            //'password_confirm' => 'required_with:password|same:password',
            'client_uuid' => 'nullable|string|exists:clients,client_uuid',
            'rol' => 'required|string|exists:roles,name',
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
    public function destroy(string $id)
    {
        //
    }

    public function getRolUsers(string $rol)
    {
        $rolUser = ['rol_user' => $rol];
        $validated = Validator::make($rolUser, [
            'rol_user' => 'required|string|exists:roles,name',
        ]);
        // Si el rol no existe lanza excepción
        if ($validated->fails()) {
            $this->service->setFailValidation($validated->errors());

            return response()->json($this->service->response, $this->service->statusCode);
        }

        $this->service->getRolUsers($rol);

        return response()->json($this->service->response, $this->service->statusCode);
    }
}
