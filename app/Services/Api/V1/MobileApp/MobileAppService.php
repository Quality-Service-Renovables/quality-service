<?php

/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\MobileApp;

use App\Models\Projects\ProjectEmployee;
use App\Models\Trademarks\Category;
use App\Models\Trademarks\Trademark;
use App\Services\Api\ServiceInterface;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class MobileAppService extends Service
{
    public string $nameService = 'mobile_app_service';

    /**
     * Creates a new trademark based on the provided request data.
     *
     * @param Request $request The request object containing the trademark data.
     *
     * @return array The response array containing the created trademark data.
     *
     * @throws Throwable If an error occurs during the creation process.
     */
    public function sync(): array
    {
        try {
            $user = auth()->user();
            /**
             * 1. Recuperar información del proyecto asociado al usuario
             * 2. Recuperar información de los clientes
             */
            $projects = ProjectEmployee::with(['project'])
                ->where([
                'user_id' => $user->id,
            ])->get();
            // Define parámetros de respuesta
            $this->statusCode = 200;
            $this->response['message'] = trans('api.created');
            $this->response['data'] = compact('projects');
        } catch (Throwable $exceptions) {
            // Parámetros de respuesta en caso de error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }
}
