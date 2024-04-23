<?php

namespace App\Http\Requests\Api\Oils;

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
            'oil_category' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('oil_categories', 'oil_category')
                    ->whereNull('deleted_at'),
            ],
            'description' => 'required|string|min:12|max:255',
            'active' => 'required|bool',
        ];
    }
}
