<?php

namespace App\Http\Requests\Api\Inspections;

use App\Http\Requests\CustomRequest;
use Illuminate\Validation\Rule;

class EquipmentRequest extends CustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'equipments.*.equipment_uuid' => [
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
        ];
    }
}
