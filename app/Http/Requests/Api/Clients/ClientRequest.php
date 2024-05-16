<?php

namespace App\Http\Requests\Api\Clients;

use App\Http\Requests\CustomRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends CustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'client' => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique('clients', 'client')
                    ->whereNull('deleted_at'),
            ],
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'legal_name' => 'nullable|string',
            'address' => 'nullable|string',
            'zipcode' => 'nullable|string',
            'phone' => 'nullable|string',
            'phone_office' => 'nullable|string',
            'open_time' => 'nullable|date_format:H:i',
            'close_time' => 'nullable|date_format:H:i',
            'office_days' => 'nullable|string',
            'website' => 'nullable|url',
            'email' => [
                'required',
                'email',
                'min:1',
                'max:255',
                Rule::unique('clients', 'email')
                    ->whereNull('deleted_at'),
            ],
            'active' => 'required|bool',
        ];
    }
}
