<?php

/** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Http\Requests\Api\Sessions;

use App\Http\Requests\CustomRequest;

class SessionRequest extends CustomRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ];
    }
}
