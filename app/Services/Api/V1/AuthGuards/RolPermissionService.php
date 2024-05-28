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

namespace App\Services\Api\V1\AuthGuards;

use App\Models\AuthGuards\RolePermissions;
use App\Models\Equipments\Category;
use App\Models\Equipments\Equipment;
use App\Models\Status\Status;
use App\Services\Api\ServiceInterface;
use App\Services\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class RolPermissionService extends Service implements ServiceInterface
{
    public string $nameService = 'rol_permission_service';

    public function create(Request $request): array
    {}

    /**
     * Retrieve all equipment data
     *
     * @return array Returns an array containing the equipment data
     */
    public function read(): array
    {
        $roles = RolePermissions::with([
            'role' => function ($query) {
                $query->select(['id', 'name']);
            }, 'permission' => function ($queryAlt) {
                $queryAlt->select(['id', 'name']);
            },
        ])->get();

        $rolesGroup = $roles->makeHidden(['role_id', 'permission_id'])->groupBy(['role.name']);

        $this->response['message'] = trans('api.readed');
        $this->response['data'] = $rolesGroup;

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

            // Actualizamos el rol
            Role::where("id", $request->id)->update(["name" => $request->name]);

            // Eliminamos permisos actuales del rol y asociamos los nuveos permisos
            RolePermissions::where("role_id", $request->id)->delete();

            foreach ($request->permissions as $permissionId) {
                RolePermissions::create([
                    "role_id" => $request->id,
                    "permission_id" => $permissionId,
                ]);
            }

            // Recupera el rol actualizado
            $roleUpdated = Role::where('id', $request->id)->with("permissions")->first();
            $this->response['data'] = $roleUpdated;

            // Registro de log
            $this->logService->create(
                $this->nameService,
                $request->all(),
                $this->response,
                'Update rol request',
            );

            // Confirmación de transacción
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            // Parámetros de respuesta en caso de error
            $this->response['status'] = 'error';
            $this->response['message'] = $exception->getMessage();
            $this->statusCode = 500;
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
    {}

    /**
     * Retrieves a category by UUID
     *
     * @param  string  $uuid  The UUID of the category to retrieve
     * @return array Returns an array containing the status, message, and data of the response
     */
    public function show(string $uuid): array
    {}
}
