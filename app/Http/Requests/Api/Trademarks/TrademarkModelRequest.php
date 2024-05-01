<?php

namespace App\Http\Requests\Api\Trademarks;

use App\Http\Requests\CustomRequest;
use Illuminate\Validation\Rule;

class TrademarkModelRequest extends CustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'trademark_model' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('trademark_models', 'trademark_model')
                    ->whereNull('deleted_at'),
            ],
            'trademark_code' => 'required|string|exists:trademarks,trademark_code',
        ];
    }
}
