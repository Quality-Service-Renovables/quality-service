<?php

namespace App\Http\Controllers\Api\V1\AuthGuards;

use App\Http\Controllers\Controller;
use App\Services\Api\V1\AuthGuards\PermissionService;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;

class PermissionController extends Controller
{
    protected PermissionService $service;

    /**
     * Constructor for the class.
     */
    public function __construct()
    {
        $this->service = new PermissionService();
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
     * Display a listing of the resource.
     */
    public function grouped(): JsonResponse
    {
        $this->service->readGrouped();

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Render the equipment component.
     */
    public function component(): Response
    {
        $this->service->read();

        return Inertia::render('Equipment', [
            'equipments' => $this->service->response['data'],
        ]);
    }
}
