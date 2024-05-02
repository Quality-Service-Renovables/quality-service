<?php

namespace App\Http\Requests\Api\Trademarks;

use App\Http\Requests\CustomRequest;
use Illuminate\Validation\Rule;

class TrademarkRequest extends CustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'trademark' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('trademarks', 'trademark')
                    ->whereNull('deleted_at'),
            ],
            'trademark_category_code' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::exists('trademark_categories', 'trademark_category_code')
                    ->whereNull('deleted_at'),
            ],
        ];
    }
}
