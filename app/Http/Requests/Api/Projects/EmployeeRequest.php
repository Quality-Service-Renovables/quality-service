<?php

namespace App\Http\Requests\Api\Projects;

use App\Http\Requests\CustomRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends CustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'project_uuid' => 'required|uuid|exists:projects,project_uuid',
            'employees.*.employee_uuid' => 'required|uuid|exists:users,uuid',
        ];
    }
}
