<?php

namespace App\Http\Requests\Api\AuthGuards;

use App\Http\Requests\CustomRequest;
use Illuminate\Validation\Rule;

class RolePermissionRequest extends CustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rol_id' => 'required|integer|exists:roles,id',
            'permission_id' => 'required|integer|exists:permissions,id',
        ];
    }
}
