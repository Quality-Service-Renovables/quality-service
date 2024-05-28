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
            'ct_trademark_code' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::exists('ct_trademarks', 'ct_trademark_code')
                    ->whereNull('deleted_at'),
            ],
        ];
    }
}
