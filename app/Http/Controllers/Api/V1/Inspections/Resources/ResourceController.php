<?php

namespace App\Http\Controllers\Api\V1\Inspections\Resources;

use App\Http\Controllers\Controller;
use App\Services\Api\V1\Inspections\Resources\ResourceService;
use Illuminate\Http\JsonResponse;

class ResourceController extends Controller
{
    protected ResourceService $service;

    public function __construct()
    {
        $this->service = new ResourceService();
    }

    /**
     * Display a listing of the resource.
     *
     * @throws \Exception
     */
    public function getInspectionDetail(string $uuid): JsonResponse
    {
        $this->service->getInspectionDetail($uuid);

        return response()->json($this->service->response, $this->service->statusCode);
    }
}
