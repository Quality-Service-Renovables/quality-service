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
            //'equipment' => 'required|string',
            //'ct_equipment_code' => 'required|string|exists:ct_equipments,ct_equipment_code',
            'equipment' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('equipments', 'equipment')
                    ->whereNull('deleted_at'),
            ],
            'equipment_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'equipment_diagram' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'serial_number' => 'nullable|string',
            'manufacture_date' => 'nullable|date_format:Y-m-d',
            'work_hours' => 'nullable|integer',
            'energy_produced' => 'nullable|integer',
            'barcode' => 'nullable|string',
            'description' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'manual' => 'nullable|file|mimes:pdf|max:2048',
            'ct_equipment_code' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::exists('ct_equipments', 'ct_equipment_code')
                    ->whereNull('deleted_at'),
            ],
            'trademark_code' => 'required|string|exists:trademarks,trademark_code',
            'trademark_model_code' => 'required|string|exists:trademark_models,trademark_model_code',
            'status_code' => 'required|string|exists:status,status_code',
            'active' => 'required|boolean',
        ];
    }
}
