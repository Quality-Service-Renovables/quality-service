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

    public function setFormFields(Request $request): JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'ct_inspection_section_uuid' => 'required|string|min:10|max:255|exists:ct_inspection_sections,ct_inspection_section_uuid',
            'fields.*.ct_inspection_form' => 'required|string|unique:ct_inspection_forms,ct_inspection_form',
            'fields.*.required' => 'required|boolean',
        ]);

        if ($validated->fails()) {
            $this->service->setFailValidation($validated->errors());
            return response()->json($this->service->response, $this->service->statusCode);
        }

        $this->service->setFormFields($request);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    public function setFormInspection(Request $request): JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'inspection_uuid' => 'required|string|min:10|max:255|exists:inspections,inspection_uuid',
            'form.*.ct_inspection_form_uuid' => 'required|string|exists:ct_inspection_forms,ct_inspection_form_uuid',
            'form.*.inspection_form_value' => 'required|string',
            'form.*.inspection_form_comments' => 'nullable|string',
        ]);

        if ($validated->fails()) {
            $this->service->setFailValidation($validated->errors());
            return response()->json($this->service->response, $this->service->statusCode);
        }

        $this->service->setFormInspection($request);

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
