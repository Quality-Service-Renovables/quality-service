<?php

namespace App\Http\Controllers\Api\V1\Inspections;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Inspections\SectionRequest;
use App\Services\Api\V1\Inspections\SectionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class SectionController extends Controller
{
    protected SectionService $service;

    public function __construct()
    {
        $this->service = new SectionService();
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
    public function create(SectionRequest $request): JsonResponse
    {
        $this->service->create($request);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionRequest $request): JsonResponse
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
        $request = (['ct_inspection_section_uuid' => $uuid]);

        if (! $this->commonValidation($request)) {
            return response()->json($this->service->response, $this->service->statusCode);
        }

        $this->service->show($uuid);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $uuid): JsonResponse
    {
        $this->service->response['message'] = 'Api edit request not available: '.$uuid;

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws \Exception
     */
    public function update(Request $request, string $uuid): JsonResponse
    {
        $request->merge([
            'ct_inspection_section_uuid' => $uuid,
            'ct_inspection_section_code' => create_slug($request->ct_inspection_section),
        ]);

        $validated = Validator::make($request->all(), [
            'ct_inspection_section_uuid' => 'required|string|exists:ct_inspection_sections,ct_inspection_section_uuid',
            'ct_inspection_section' => 'required|string',
            'ct_inspection_section_code' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('ct_inspection_sections', 'ct_inspection_section_code')
                    ->whereNot('ct_inspection_section_uuid', $uuid)
                    ->whereNull('deleted_at'),
            ],
            'ct_inspection_uuid' => 'required|string|exists:ct_inspections,ct_inspection_uuid',
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
     *
     * @throws \Exception
     */
    public function destroy(string $uuid): JsonResponse
    {
        $request = ['inspection_uuid' => $uuid];

        if (! $this->commonValidation($request)) {
            return response()->json($this->service->response, $this->service->statusCode);
        }

        $this->service->delete($uuid);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Render the project component.
     */
    public function component(): Response
    {
        $this->service->read();

        return Inertia::render('Projects', [
            'projects' => $this->service->response['data'],
        ]);
    }

    /**
     * Perform common validation for the request data.
     *
     *
     * @return bool Returns true if validation passes, false otherwise.
     */
    private function commonValidation(array $request): bool
    {
        $validated = Validator::make($request, [
            'ct_inspection_section_uuid' => 'required|uuid|exists:ct_inspection_sections,ct_inspection_section_uuid',
        ]);

        if ($validated->fails()) {
            $this->service->setFailValidation($validated->errors());

            return false;
        }

        return true;
    }
}
