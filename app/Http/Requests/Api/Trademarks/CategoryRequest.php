<?php

namespace App\Http\Requests\Api\Trademarks;

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
            'trademark_category' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('trademark_categories', 'trademark_category')
                    ->whereNull('deleted_at'),
            ],
        ];
    }
}
