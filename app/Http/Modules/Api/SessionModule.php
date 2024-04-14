<?php

namespace App\Http\Modules\Api;

use App\Http\Modules\MainModule;
use App\Http\Requests\Api\Sessions\SessionRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class SessionModule extends MainModule
{
    public string $nameModule = 'session_module';

    public function login(SessionRequest $request): array
    {
        try {

            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                $this->statusCode = 404;
                $this->response['message'] = 'The provided credentials are incorrect.';
            } else {
                $this->response['message'] = 'Login success';
                $this->response['data'] = $user->createToken('auth_token')->plainTextToken;

                $this->logModule->create(
                    $this->nameModule,
                    $request->all(),
                    $this->response,
                    'Api login request',
                    $user->id,
                );
                // Fail register log
                if (! $this->logModule->isSaved) {
                    $user->tokens()->delete();
                    $this->statusCode = 200;
                    $this->response['message'] = 'Security process revoke current tokens, register log process fail!';
                }
            }

        } catch (Exception $exception) {
            $this->statusCode = 500;
            $this->response['message'] = $exception->getMessage();
        }

        return $this->response;
    }
}
