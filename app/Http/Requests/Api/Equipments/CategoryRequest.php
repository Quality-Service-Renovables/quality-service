<?php

namespace App\Http\Requests\Api\Equipments;

use App\Http\Requests\CustomRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends CustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'ct_equipment' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('ct_equipments', 'ct_equipment')
                    ->whereNull('deleted_at'),
            ],
            'description' => 'required|string|min:3|max:255',
            'active' => 'required|bool',
        ];
    }
}
