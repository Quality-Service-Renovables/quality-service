<?php

namespace App\Http\Controllers\Api\V1\Inspections\Reports;

use App\Http\Controllers\Controller;
use App\Services\Api\V1\Inspections\Reports\ReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    protected ReportService $service;

    /**
     * Initialize a new instance of the class.
     *
     * @return void
     */
    public function __construct()
    {
        $this->service = new ReportService();
    }

    /**
     * Display the specified resource.
     *
     * @throws \Exception
     */
    public function getDocument(string $uuid): JsonResponse|Response
    {
        $request = (['inspection_uuid' => $uuid]);
        if (!$this->commonValidation($request)) {
            return response()->json($this->service->response, $this->service->statusCode);
        }

        $this->service->getDocument($uuid);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    public function streamDocument(string $uuid){
        return $this->service->streamDocument($uuid);
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
