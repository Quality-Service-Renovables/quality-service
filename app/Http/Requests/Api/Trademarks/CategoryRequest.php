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
            'ct_trademark' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('ct_trademarks', 'ct_trademark')
                    ->whereNull('deleted_at'),
            ],
        ];
    }
}
