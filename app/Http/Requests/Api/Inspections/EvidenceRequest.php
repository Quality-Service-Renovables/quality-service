<?php

namespace App\Http\Requests\Api\Inspections;

use App\Http\Requests\CustomRequest;
use Illuminate\Validation\Rule;

class EvidenceRequest extends CustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'evidence_store' => 'required|file|mimes:jpeg,png,jpg',
            'evidence_store_secondary' => 'nullable|file|mimes:jpeg,png,jpg',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'inspection_uuid' => 'required|uuid|exists:inspections,inspection_uuid',
            'position' => 'required|integer',
            'inspection_form_id' => 'required|integer|exists:inspection_forms,inspection_form_id',
        ];
    }
}
