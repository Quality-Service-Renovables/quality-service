<?php

namespace App\Http\Requests\Api\Equipments;

use App\Http\Requests\CustomRequest;
use Illuminate\Validation\Rule;

class EquipmentRequest extends CustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'equipment' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('equipments', 'equipment')
                    ->whereNull('deleted_at'),
            ],
            'serial_number' => 'nullable|string',
            'equipment_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:3052',
            'equipment_diagram' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:3052',
            'manual' => 'nullable|file|mimes:pdf|max:3052',
            'ct_equipment_code' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::exists('ct_equipments', 'ct_equipment_code')
                    ->whereNull('deleted_at'),
            ],
            'trademark' => 'nullable|string',
            'model' => 'nullable|string',
            'status_code' => 'required|string|exists:status,status_code',
            'active' => 'required|boolean',
        ];
    }
}
