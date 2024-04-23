<?php

namespace App\Http\Requests\Api\Oils;

use App\Http\Requests\CustomRequest;
use Illuminate\Validation\Rule;

class OilRequest extends CustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'oil' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('oils', 'oil')
                    ->whereNull('deleted_at'),
            ],
            'viscosity' => 'nullable|string',
            'description' => 'required|string',
            'oil_category_code' => 'required|string|exists:oil_categories,oil_category_code',
            'trademark_code' => 'required|string|exists:trademarks,trademark_code',
            'trademark_model_code' => 'required|string|exists:trademark_models,trademark_model_code',
            'production_date' => 'nullable|date',
            'expiration_date' => 'nullable|date',
            'quantity' => 'nullable|integer',
            'active' => 'nullable|boolean',
        ];
    }
}
