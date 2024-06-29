<?php

namespace App\Http\Requests\Api\Status;

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
            'ct_status' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('status', 'status')
                    ->whereNull('deleted_at'),
            ],
            'description' => 'required|string|min:3|max:255',
            'active' => 'required|bool',
        ];
    }
}
