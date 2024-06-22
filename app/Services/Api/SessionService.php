<?php

namespace App\Services\Api;

use App\Http\Requests\Api\Sessions\SessionRequest;
use App\Models\Users\User;
use App\Services\Service;
use Exception;
use Illuminate\Support\Facades\Hash;

class SessionService extends Service
{
    public string $nameService = 'session_service';

    public function login(SessionRequest $request): array
    {
        try {

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                $this->statusCode = 404;
                $this->response['message'] = 'The provided credentials are incorrect.';
            } else {
                $this->response['message'] = 'Login success';
                $this->response['data'] = $user->createToken('auth_token')->plainTextToken;

                $this->logService->create(
                    $this->nameService,
                    $request->all(),
                    $this->response,
                    'Api login request',
                    $user->id,
                );
                // Fail register log
                if (!$this->logService->log) {
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
