<?php

namespace App\Http\Controllers\Api\V1\Inspections;

use App\Http\Controllers\Controller;
use App\Services\Api\V1\Inspections\InspectionFormService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FormController extends Controller
{
    protected InspectionFormService $service;

    /**
     * Create a new instance of the class.
     *
     * @return void
     */
    public function __construct()
    {
        $this->service = new InspectionFormService();
    }

    /**
     * Sets the form data based on the request.
     *
     * @param Request $request The HTTP request.
     *
     * @return JsonResponse The JSON response.
     */
    public function setForm(Request $request): JsonResponse
    {
        $this->service->setForm($request);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Sets the form inspection.
     *
     * @param Request $request The request object.
     */
    public function setFormInspection(Request $request): JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'inspection_uuid' => 'required|string|min:10|max:255|exists:inspections,inspection_uuid',
            'form.*.ct_inspection_form_uuid' => 'required|string|exists:ct_inspection_forms,ct_inspection_form_uuid',
            'form.*.inspection_form_value' => 'nullable|string',
            'form.*.inspection_form_comments' => 'nullable|string',
        ]);

        if ($validated->fails()) {
            $this->service->setFailValidation($validated->errors());

            return response()->json($this->service->response, $this->service->statusCode);
        }

        $this->service->setFormInspection($request);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Gets the form.
     *
     * @param string $uuid The UUID of the form.
     */
    public function getForm(string $uuid): JsonResponse
    {
        if (!$this->commonValidation($uuid)) {
            return response()->json($this->service->response, $this->service->statusCode);
        }
        $this->service->getForm($uuid);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Gets the form related to an inspection.
     *
     * @param string $uuid The UUID of the inspection.
     */
    public function getFormInspection(string $uuid): JsonResponse
    {
        $request = ['inspection_uuid' => $uuid];

        $validated = Validator::make($request, [
            'inspection_uuid' => 'required|string|min:10|max:255|exists:inspections,inspection_uuid',
        ]);

        if ($validated->fails()) {
            $this->service->setFailValidation($validated->errors());

            return response()->json($this->service->response, $this->service->statusCode);
        }

        $this->service->getFormInspection($uuid);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Gets the form related to an inspection.
     *
     * @param string $uuid The UUID of the inspection.
     */
    public function getFormEvidences(string $id): JsonResponse
    {
        $request = ['inspection_form_id' => $id];

        $validated = Validator::make($request, [
            'inspection_form_id' => 'required|integer|exists:inspection_forms,inspection_form_id',
        ]);

        if ($validated->fails()) {
            $this->service->setFailValidation($validated->errors());

            return response()->json($this->service->response, $this->service->statusCode);
        }

        $this->service->getFormEvidences($id);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    public function getFieldSuggestions($uuid): JsonResponse
    {
        $request = ['ct_inspection_form_uuid' => $uuid];
        $validated = Validator::make($request, [
            'ct_inspection_form_uuid' => 'required|string|min:10|max:255|exists:ct_inspection_forms,ct_inspection_form_uuid',
        ]);

        if ($validated->fails()) {
            $this->service->setFailValidation($validated->errors());

            return response()->json($this->service->response, $this->service->statusCode);
        }

        $this->service->getFieldSuggestions($uuid);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Sets the form fields.
     *
     * @param Request $request The request object.
     */
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

    /**
     * Updates a form field.
     *
     * @param Request $request The HTTP request.
     * @param string  $uuid    The UUID of the form field.
     *
     * @return JsonResponse The JSON response containing the result of the update.
     */
    public function updateFormField(Request $request, string $uuid): JsonResponse
    {
        $request->merge(['ct_inspection_form_uuid' => $uuid]);

        $validated = Validator::make($request->all(), [
            'ct_inspection_form_uuid' => 'required|string|min:10|max:255|exists:ct_inspection_forms,ct_inspection_form_uuid',
            'ct_inspection_section_uuid' => 'required|string|min:10|max:255|exists:ct_inspection_sections,ct_inspection_section_uuid',
            'ct_inspection_form' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('ct_inspection_forms', 'ct_inspection_form')
                    ->whereNot('ct_inspection_form_uuid', $uuid)
                    ->whereNull('deleted_at'),
            ],
            'required' => 'required|boolean',
        ]);

        if ($validated->fails()) {
            $this->service->setFailValidation($validated->errors());

            return response()->json($this->service->response, $this->service->statusCode);
        }

        $this->service->updateFormField($request);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Deletes a form field.
     *
     * @param string $uuid The UUID of the form field to delete.
     *
     * @return JsonResponse The JSON response.
     */
    public function deleteFormField(string $uuid): JsonResponse
    {
        $request = ['ct_inspection_form_uuid' => $uuid];

        $validated = Validator::make($request, [
            'ct_inspection_form_uuid' => 'required|string|min:10|max:255|exists:ct_inspection_forms,ct_inspection_form_uuid',
        ]);

        if ($validated->fails()) {
            $this->service->setFailValidation($validated->errors());

            return response()->json($this->service->response, $this->service->statusCode);
        }

        $this->service->deleteFormField($uuid);

        return response()->json($this->service->response, $this->service->statusCode);
    }

    /**
     * Performs common validation for a form field.
     *
     * @param string $uuid The UUID of the form field.
     *
     * @return bool True if the validation passes, false otherwise.
     */
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
