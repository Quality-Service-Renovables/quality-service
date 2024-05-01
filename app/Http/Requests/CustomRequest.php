<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpMultipleClassDeclarationsInspection */

namespace App\Http\Requests;

use App\Services\Service;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class CustomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Handle a failed validation attempt.
     *
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     *
     * @return void
     *
     */
    protected function failedValidation(Validator $validator): void
    {
        $errors = (new ValidationException($validator))->errors();
        $service = new Service();
        $service->response['status'] = 'fail';
        $service->response['message'] = $errors;
        $service->response['data'] = [];
        $service->statusCode = 422;

        throw new HttpResponseException(
            response()->json($service->response, $service->statusCode)
        );
    }
}
