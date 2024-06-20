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
            'resume' => 'required',
            'conclusion' => 'required|string',
            'recomendations' => 'nullable|string',
            'ct_inspection_code' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::exists('ct_inspections', 'ct_inspection_code')
                    ->whereNull('deleted_at'),
            ],
            'equipment_uuid' => 'required|uuid|exists:equipments,equipment_uuid',
            'status_code' => 'required|string|exists:status,status_code',
            'project_uuid' => 'required|string|exists:projects,project_uuid',
            'client_uuid' => 'required|uuid|exists:clients,client_uuid',
        ];
    }
}
