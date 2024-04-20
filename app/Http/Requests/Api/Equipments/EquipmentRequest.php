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
            //'equipment_category_code' => 'required|string|exists:equipment_categories,equipment_category_code',
            'equipment' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('equipments', 'equipment')
                    ->whereNull('deleted_at'),
            ],
            'equipment_category_code' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::exists('equipment_categories', 'equipment_category_code')
                    ->whereNull('deleted_at'),
            ],
            'trademark_code' => 'required|string|exists:trademarks,trademark_code',
            'trademark_model_code' => 'required|string|exists:trademark_models,trademark_model_code',
            'status_code' => 'required|string|exists:status,status_code',
        ];
    }
}
