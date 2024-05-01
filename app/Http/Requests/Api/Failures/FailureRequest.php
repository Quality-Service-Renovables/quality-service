<?php

namespace App\Http\Requests\Api\Failures;

use App\Http\Requests\CustomRequest;
use Illuminate\Validation\Rule;

class FailureRequest extends CustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'failure' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('failures', 'failure')
                    ->whereNull('deleted_at'),
            ],
            'description' => 'nullable|string|min:10|max:255',
            'failure_category_code' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::exists('failure_categories', 'failure_category_code')
                    ->whereNull('deleted_at'),
            ],
            'active' => 'required|boolean',
        ];
    }
}
