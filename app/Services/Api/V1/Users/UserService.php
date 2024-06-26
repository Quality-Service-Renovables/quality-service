<?php
/**
 * Equipment Service.
 *
 * Register equipments
 *
 * @author   Luis Adrian Olvera Facio
 *
 * @version  1.0
 *
 * @since    2024.1
 */

/** @noinspection NullPointerExceptionInspection */

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Api\V1\Users;

use App\Models\Clients\Client;
use App\Models\Equipments\Category;
use App\Models\Equipments\Equipment;
use App\Models\Users\User;
use App\Services\Api\ServiceInterface;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class UserService extends Service implements ServiceInterface
{
    public string $nameService = 'user_service';

    private string $imageDefault = 'img/users/default.png';

    public function create(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Agrega atributos a la solicitud
            $client = Client::where('client_uuid', '=', $request->client_uuid)
                ->first();
            $request->merge([
                'uuid' => Str::uuid()->toString(),
                'client_id' => $client->client_id,
            ]);

            // Establecer imágen por defecto en caso de no seleccionar alguna.
            if (! $request->image_profile) {
                $request->merge(['image_profile' => $this->imageDefault]);
            } else {
                $request = $this->storeFile($request,
                    'image_profile',
                    'users'
                );
            }
            // Registra los atributos de la solicitud al usuario
            $user = User::create($request->all());
            $user->assignRole($request->rol);

            $this->statusCode = 201;
            $this->response['message'] = trans('api.created');
            $this->response['data'] = $user;
            // Registro en log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                trans('api.message_log'),
            );
            // Finaliza Transacción
            DB::commit();
        } catch (Throwable $exceptions) {
            DB::rollBack();
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }

    public function read(): array
    {
        $this->response['message'] = trans('api.read');
        $this->response['data'] = User::with(['client', 'roles'])->get();

        return $this->response;
    }

    /**
     * Update equipment data
     *
     * @param  Request  $request  The request object containing the updated data
     * @return array Returns an array containing the updated equipment data
     */
    public function update(Request $request): array
    {
        try {
            // Control de transacciones
            DB::beginTransaction();
            // Obtener el usuario a actualizar
            $user = User::where('uuid', '=', $request->uuid)->first();
            // Agrega atributos a la solicitud
            $client = Client::where('client_uuid', '=', $request->client_uuid)
                ->first();
            // Asociación de cliente a la solicitud.
            $request->merge([
                'client_id' => $client->client_id,
            ]);
            /**
             * Elimina la imágen anterior siempre y cuando no sea la imágen por defecto.
             * Esto con la finalidad de eliminar imágenes huérfanas en la aplicación.
             * */
            if ($user->image_profile && ($user->image_profile !== $request->image_profile)) {
                $this->purgeFile($user->image_profile);
                $request = $this->storeFile($request,
                    'image_profile',
                    'users'
                );
            } else {
                $request->merge(['image_profile' => $this->imageDefault]);
            }

            $request->merge(['active' => $request->active == 'true' ? 1 : 0]);

            // Registra los atributos de la solicitud al usuario
            $user?->update($request->except([
                'client_uuid',
            ]));
            // Asignación de rol
            $user->assignRole($request->rol);
            // Respuesta del módulo
            $this->response['message'] = trans('api.updated');
            $this->response['data'] = $user;
            // Registro en log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                trans('api.message_log'),
            );
            // Finaliza Transacción
            DB::commit();
        } catch (Throwable $exceptions) {
            DB::rollBack();
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Delete equipment by UUID.
     *
     * @param  string  $uuid  The UUID of the equipment to be deleted.
     * @return array The response array with status, message, and data.
     */
    public function delete(string $uuid): array
    {
        try {
            // Aplica soft delete al equipo especificado por medio de su uuid
            User::where('uuid', $uuid)->update(['deleted_at' => now()]);
            $this->logService->create(
                $this->nameService,
                compact('uuid'),
                $this->response,
                trans('api.message_log'),
            );
            $this->response['message'] = trans('api.deleted');
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Retrieves a category by UUID
     *
     * @param  string  $uuid  The UUID of the category to retrieve
     * @return array Returns an array containing the status, message, and data of the response
     */
    public function show(string $uuid): array
    {
        try {
            // Obtiene categoria del equipo
            $equipment = Equipment::with([
                'category', 'status', 'trademark', 'model',
            ])->where('equipment_uuid', $uuid)->first();
            $this->response['message'] = $equipment === null
                ? trans('api.not_found')
                : trans('api.show');
            $this->response['data'] = $equipment ?? [];
        } catch (Throwable $exceptions) {
            // Manejo del error
            $this->setExceptions($exceptions);
        }

        // Respuesta del módulo
        return $this->response;
    }

    /**
     * Retrieves users based on their role.
     *
     * @param  string  $rol  The role to filter users.
     * @return array The response containing the users.
     */
    public function getRolUsers(string $rol): array
    {
        $this->response['message'] = trans('api.read');
        $this->response['data'] = User::role($rol)->get();

        return $this->response;
    }
}
