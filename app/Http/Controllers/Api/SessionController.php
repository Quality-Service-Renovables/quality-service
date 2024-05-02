<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Sessions\SessionRequest;
use App\Services\Api\SessionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    protected SessionService $service;

    public function __construct()
    {
        $this->service = new SessionService();
    }

    public function login(SessionRequest $request)
    {
        $this->service->login($request);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Session closed',
        ]);
    }
}
