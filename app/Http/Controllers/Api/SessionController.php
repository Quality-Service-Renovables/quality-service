<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Modules\Api\SessionModule;
use App\Http\Requests\Api\Sessions\SessionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    protected SessionModule $module;

    public function __construct()
    {
        $this->module = new SessionModule();
    }

    public function login(SessionRequest $request): JsonResponse
    {
        $this->module->login($request);

        return response()->json($this->module->response, $this->module->statusCode);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Session closed',
        ]);
    }
}
