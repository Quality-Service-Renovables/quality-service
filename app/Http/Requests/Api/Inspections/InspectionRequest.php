<?php

namespace App\Http\Requests\Api\Inspections;

use App\Http\Requests\CustomRequest;
use Illuminate\Validation\Rule;

class InspectionRequest extends CustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'resume' => 'nullable|string',
            'conclusion' => 'nullable|string',
            'recomendations' => 'nullable|string',
            'location' => 'nullable|string',
            'equipment_fields_report' => 'nullable|string',
            'ct_inspection_code' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::exists('ct_inspections', 'ct_inspection_code')
                    ->whereNull('deleted_at'),
            ],
            'project_uuid' => 'required|string|exists:projects,project_uuid',
            'diagnosis_user_id' => 'nullable|int|exists:users,id',
            'client_uuid' => 'required|uuid|exists:clients,client_uuid',
            'escala_condicion' => 'nullable|string',
            'ct_risk_id' => 'required|int|exists:ct_risks,ct_risk_id',
        ];
    }
}
