<?php

namespace App\Http\Requests\Api\Inspections;

use App\Http\Requests\CustomRequest;

class CategoryRequest extends CustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ct_inspection' => 'required|string|min:10|max:255|unique:ct_inspections,ct_inspection,NULL,ct_inspection_uuid,deleted_at,NULL',
            'description' => 'required|string|min:10|max:255',
            'required_fields_report	' => 'nullable|string',
            'active' => 'required|bool',
        ];
    }
}
