<?php

namespace App\Http\Controllers\Api\V1\Inspections;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Inspections\CategoryRequest;
use App\Services\Api\V1\Inspections\RiskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RiskController extends Controller
{

    /**
     * Constructor function for the class.
     */
    public function __construct()
    {
        $this->service = new RiskService();
    }

    /**
     * Display a listing of the resource.
     *
     * @throws \Exception
     */
    public function index(): JsonResponse
    {
        $this->service->read();

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): JsonResponse
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        $this->service->create($request);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Display the specified resource.
     *
     * @throws \Exception
     */
    public function show(string $uuid): JsonResponse
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid): JsonResponse
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws \Exception
     */
    public function update(Request $request, string $uuid): JsonResponse
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \Exception
     */
    public function destroy(string $uuid): JsonResponse
    {
    }
}
