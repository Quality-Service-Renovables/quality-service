<?php

namespace App\Http\Controllers\Api\V1\MobileApp;

use App\Http\Controllers\Controller;
use App\Services\Api\V1\MobileApp\MobileAppService;
use Illuminate\Http\JsonResponse;

class MobileAppController extends Controller
{
    protected MobileAppService $service;

    /**
     * Constructor for the class.
     */
    public function __construct()
    {
        $this->service = new MobileAppService();
    }

    /**
     * Display a listing of the resource.
     */
    public function sync(): JsonResponse
    {
        $this->service->sync();

        return response()->json($this->service->response, $this->service->statusCode);
    }
}
