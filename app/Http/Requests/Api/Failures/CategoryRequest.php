<?php

namespace App\Http\Requests\Api\Failures;

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
            'failure_category' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('failures', 'failure')
                    ->whereNull('deleted_at'),
            ],
            'description' => 'nullable|string|min:10|max:255',
            'is_default' => 'nullable|boolean',
            'dependency' => 'nullable|integer',
            'active' => 'required|boolean',
        ];
    }
}
