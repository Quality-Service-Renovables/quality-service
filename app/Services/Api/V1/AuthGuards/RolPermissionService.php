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

use App\Services\Service;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Status\Status;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\Equipments\Category;
use App\Models\Equipments\Equipment;
use App\Services\Api\ServiceInterface;
use Spatie\Permission\Models\Permission;

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
        $roles = Role::with("permissions")->get();

        $this->response['message'] = trans('api.read');
        $this->response['data'] = $roles;

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
            Role::where("id", $request->id)->update(["description" => $request->description]);
            $permissions = Permission::whereIn('id', $request->permissions)->get();

            // Eliminamos permisos actuales del rol y Asignamos los permisos al rol
            $role = Role::where('id', $request->id)->first();
            $role->revokePermissionTo($role->permissions);
            $role->syncPermissions($permissions);

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
