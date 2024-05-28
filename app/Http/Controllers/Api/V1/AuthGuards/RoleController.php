<?php

namespace App\Http\Controllers\Api\V1\AuthGuards;

use App\Http\Controllers\Controller;
use App\Services\Api\V1\AuthGuards\RolService;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;

class RoleController extends Controller
{
    protected RolService $service;

    /**
     * Constructor for the class.
     */
    public function __construct()
    {
        $this->service = new RolService();
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
