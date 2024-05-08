<?php
/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace Database\Seeders;

use App\Models\AuthGuards\Permission;
use App\Models\AuthGuards\Role;
use App\Models\AuthGuards\RolePermissions;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getPermissions() as $permission) {
            Permission::updateOrCreate(['guard_name' => $permission['guard_name']], $permission);
        }

        $permissions = Permission::all();
        $rols = Role::all();

        foreach ($this->getUserPermissions() as $rol => $userPermissions) {
            foreach ($userPermissions as $userPermission) {
                $permissionId = $permissions->where('guard_name', '=', $userPermission)->first()->id;
                $rolId = $rols->where('guard_name', '=', $rol)->first()->id;
                if($userPermission) {
                    RolePermissions::updateOrCreate([
                        'permission_id' => $permissionId,
                        'role_id' => $rolId,
                    ]);
                }
            }
        }
    }

    /**
     * Retrieve the list of permissions.
     *
     * @return array The array of permissions, each with a name and guard_name.
     */
    private function getPermissions(): array
    {
        return [
            [
                'name' => 'Módulo de usuarios',
                'guard_name' => 'users',
            ],
            [
                'name' => 'Módulo de clientes',
                'guard_name' => 'client',
            ],
            [
                'name' => 'Módulo de Inspecciones',
                'guard_name' => 'inspections',
            ],
            [
                'name' => 'Módulo de Equipos',
                'guard_name' => 'equipments',
            ],
            [
                'name' => 'Módulo de aceites',
                'guard_name' => 'oils',
            ],
            [
                'name' => 'Módulo de marcas y modelos comerciales',
                'guard_name' => 'trademarks',
            ],
            [
                'name' => 'Módulo de Fallas',
                'guard_name' => 'failures',
            ],
        ];
    }

    private function getUserPermissions(): array
    {
        return [
                'admin' => ['users', 'equipments', 'inspections', 'oils', 'trademarks', 'failures'],
                'technical' => ['inspections', 'trademarks', 'failures'],
                'client' => ['inspections'],
            ];
    }
}
