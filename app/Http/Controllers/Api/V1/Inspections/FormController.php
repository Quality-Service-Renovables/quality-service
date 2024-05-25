<?php

namespace App\Http\Controllers\Api\V1\Inspections;

use App\Http\Controllers\Controller;
use App\Services\Api\V1\Inspections\Forms\FormService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    protected FormService $service;

    public function __construct()
    {
        $this->service = new FormService();
    }

    public function setForm(Request $request): JsonResponse
    {
        $this->service->setForm($request);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    public function getForm(string $uuid): JsonResponse
    {
        if (! $this->commonValidation($uuid)) {
            return response()->json($this->service->response, $this->service->statusCode);
        }
        $this->service->getForm($uuid);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    private function commonValidation(string $uuid): bool
    {
        $request = ['ct_inspection_uuid' => $uuid];

        $validated = Validator::make($request, [
            'ct_inspection_uuid' => 'required|string|min:10|max:255|exists:ct_inspections,ct_inspection_uuid',
        ]);

        if ($validated->fails()) {
            $this->service->setFailValidation($validated->errors());

            return false;
        }

        return true;
    }
}
