<?php

namespace App\Http\Requests\Api\Inspections;

use App\Http\Requests\CustomRequest;
use Illuminate\Validation\Rule;

class SectionRequest extends CustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'ct_inspection_section' => 'required|string',
            'ct_inspection_uuid' => 'required|string|exists:ct_inspections,ct_inspection_uuid',
        ];
    }
}
