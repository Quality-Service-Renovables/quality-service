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
            'inspection_category' => 'required|string|min:10|max:255|unique:inspection_categories,inspection_category,NULL,inspection_category_uuid,deleted_at,NULL',
            'description' => 'required|string|min:10|max:255',
            'active' => 'required|bool',
        ];
    }
}
