<?php

/**
 * @author  Luis Adrian Olvera Facio
 *
 * @version 1.0.0
 */

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ApiController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::all();
        if ($users->count() === 0) {
            return response()->json(
                ['message' => 'Not users found'],
                404
            );
        }

        $users->makeHidden($this->hiddenFields(['uuid']));

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        return $this->setUser($request);
    }

    /**
     * Display the specified resource.
     *
     * @param string $uuid Unique identifier
     *
     * @return JsonResponse Response json format
     */
    public function show(string $uuid): JsonResponse
    {
        $user = User::where('uuid', $uuid)->first();
        if (!$user) {
            return response()->json(
                ['message' => 'User not found'],
                404
            );
        }

        $user->makeHidden($this->hiddenFields());

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage by uuid.
     *
     * @param Request $request Request given from client
     * @param string  $uuid    Unique identifier
     *
     * @return JsonResponse Response json format
     */
    public function update(Request $request, string $uuid): JsonResponse
    {
        return $this->setUser($request, $uuid);
    }

    /**
     * Remove item from uuid
     *
     * @param string $uuid Unique identifier
     *
     * @return JsonResponse Response json format
     */
    public function destroy(string $uuid): JsonResponse
    {
        $fields = compact('uuid');
        $validation = Validator::make(
            $fields,
            ['uuid' => 'uuid']
        );
        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $user = User::where('uuid', $uuid)->first();
        $user->delete();

        return response()->json(
            ['message' => 'User deleted'],
            204
        );
    }

    /**
     * @param Request $request Request given from client
     * @param         $uuid    | Unique Identifier
     *
     * @return JsonResponse Json response
     */
    private function setUser(Request $request, ?string $uuid = null): JsonResponse
    {
        if ($uuid === null) {
            $user = new User();
            $stateHttp = 201;
        } else {
            $user = User::where('uuid', $uuid)->first();
            $stateHttp = 200;
        }

        $validation = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'email' => [
                    'required',
                    Rule::unique('users')->ignore($user->id),
                ],
            ]
        );
        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        ($uuid === null) ? $this->createUser($user, $request) : $this->updateUser($user, $request);

        return response()->json($user, $stateHttp);
    }

    /**
     * @param User    $user    Instance of user
     * @param Request $request Request given from client
     *
     * @return void Not response
     */
    private function createUser(User $user, Request $request): void
    {
        $user->uuid = Str::uuid();
        $user->password = Hash::make($request->password);
        $this->updateCommonFields($user, $request, ['uuid']);
    }

    /**
     * @param User    $user    Instance of user given
     * @param Request $request Request from client
     *
     * @return void Not response
     */
    private function updateUser(User $user, Request $request): void
    {
        $user->password = Hash::make($request->password);
        $this->updateCommonFields($user, $request);
    }

    /**
     * @param User    $user       Instancia de usuario
     * @param Request $request    Request given from client
     * @param array   $showFields Array with fields to show
     *
     * @return void Not response
     */
    private function updateCommonFields(User $user, Request $request, array $showFields = []): void
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->makeHidden($this->hiddenFields($showFields));
        $user->save();
    }

    /**
     * @param array $exceptions Array exceptions to show
     *
     * @return string[] Array with fields to hide
     */
    private function hiddenFields(array $exceptions = []): array
    {
        $hiddenFields = [
            'id',
            'uuid',
            'email_verified_at',
            'created_at',
            'updated_at',
        ];
        foreach ($exceptions as $exception) {
            $position = array_search($exception, $hiddenFields, true);
            if ($position !== false) {
                unset($hiddenFields[$position]);
            }
        }

        return $hiddenFields;
    }
}
