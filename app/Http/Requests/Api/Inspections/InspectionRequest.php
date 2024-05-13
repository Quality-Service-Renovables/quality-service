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
            'resume' => 'required|string',
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
        ];
    }
}
