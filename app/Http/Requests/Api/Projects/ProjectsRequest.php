<?php

namespace App\Http\Requests\Api\Projects;

use App\Http\Requests\CustomRequest;
use Illuminate\Validation\Rule;

class ProjectsRequest extends CustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'project_name' => 'required|string|min:10|max:255',
            'status_uuid' => 'required|string|exists:status,status_uuid',
            'client_uuid' => 'required|string|exists:clients,client_uuid',
            'description' => 'required|string|min:3|max:255',
        ];
    }
}
