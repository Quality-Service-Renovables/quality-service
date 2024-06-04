<?php

namespace App\Http\Controllers\Api\V1\Inspections\Reports;

use App\Http\Controllers\Controller;
use App\Models\Inspections\Inspection;
use App\Services\Api\V1\Inspections\Reports\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ReportController extends Controller
{
    protected ReportService $service;

    public function __construct()
    {
        $this->service = new ReportService();
    }

    public function getResume(string $uuid)
    {
        $request = (['inspection_uuid' => $uuid]);
        if (! $this->commonValidation($request)) {
            return response()->json($this->service->response, $this->service->statusCode);
        }

        return $this->service->getResume($uuid);
    }

    /**
     * Display the specified resource.
     *
     * @throws \Exception
     */
    public function getDocument(string $uuid)
    {
        $request = (['inspection_uuid' => $uuid]);
        if (! $this->commonValidation($request)) {
            return response()->json($this->service->response, $this->service->statusCode);
        }

        $inspection = Inspection::with([
            'equipment.equipment',
            'category.sections.subSections.fields.result',
            'equipmentsInspection.equipment',
            'evidences',
        ])->where('inspection_uuid', $uuid)->first();

        $document = PDF::loadView('api.V1.Inspections.Reports.inspection_report', compact('inspection'));

        return $document->download();

        //return $this->service->getDocument($uuid);
    }

    /**
     * Update the specified resource in storage.
     *
     * @throws \Exception
     */
    public function update(Request $request, string $uuid): JsonResponse
    {
        $request->merge(['inspection_equipment_uuid' => $uuid]);
        $validated = Validator::make($request->all(), [
            'inspection_equipment_uuid' => 'required|uuid|exists:inspection_equipments,inspection_equipment_uuid',
            'equipment_uuid' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::exists('equipments', 'equipment_uuid')
                    ->whereNull('deleted_at'),
            ],
            'inspection_uuid' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::exists('inspections', 'inspection_uuid')
                    ->whereNull('deleted_at'),
            ],
        ]);

        if ($validated->fails()) {
            $this->service->setFailValidation($validated->errors());

            return response()->json($this->service->response, $this->service->statusCode);
        }

        $this->service->update($request);

        return response()->json($this->service->response, $this->service->statusCode);
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
            'inspection_uuid' => 'required|uuid|exists:inspections,inspection_uuid',
        ]);

        if ($validated->fails()) {
            $this->service->setFailValidation($validated->errors());

            return false;
        }

        return true;
    }
}
