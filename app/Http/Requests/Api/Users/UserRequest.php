<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\CustomRequest;

class UserRequest extends CustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'image_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|alpha_num',
            'password' => 'required|string|min:4|max:12',
            'password_confirm' => 'required_with:password|same:password',
            'client_uuid' => 'nullable|string|exists:clients,client_uuid',
            'rol' => 'required|string|exists:roles,name',
        ];
    }
}
