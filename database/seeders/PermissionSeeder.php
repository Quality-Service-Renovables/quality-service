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
            // Usuarios
            [
                'name' => 'Módulo de usuarios',
                'guard_name' => 'users',
            ],
            [
                'name' => 'Módulo de usuarios - Crear',
                'guard_name' => 'users.create',
            ],
            [
                'name' => 'Módulo de usuarios - Leer',
                'guard_name' => 'users.read',
            ],
            [
                'name' => 'Módulo de usuarios - Editar',
                'guard_name' => 'users.update',
            ],
            [
                'name' => 'Módulo de usuarios - Eliminar',
                'guard_name' => 'users.delete',
            ],
            // Equipos
            [
                'name' => 'Módulo de Equipos',
                'guard_name' => 'equipments',
            ],
            [
                'name' => 'Módulo de Equipos - Crear',
                'guard_name' => 'equipments.create',
            ],
            [
                'name' => 'Módulo de Equipos - Leer',
                'guard_name' => 'equipments.read',
            ],
            [
                'name' => 'Módulo de Equipos - Editar',
                'guard_name' => 'equipments.update',
            ],
            [
                'name' => 'Módulo de Equipos - Eliminar',
                'guard_name' => 'equipments.delete',
            ],
            // Categorias de equipos
            [
                'name' => 'Módulo de Categorías de Equipos',
                'guard_name' => 'equipments_categories',
            ],
            [
                'name' => 'Módulo de Categorías de Equipos - Crear',
                'guard_name' => 'equipments_categories.create',
            ],
            [
                'name' => 'Módulo de Categorías de Equipos - Leer',
                'guard_name' => 'equipments_categories.read',
            ],
            [
                'name' => 'Módulo de Categorías de Equipos - Editar',
                'guard_name' => 'equipments_categories.update',
            ],
            [
                'name' => 'Módulo de Categorías de Equipos - Eliminar',
                'guard_name' => 'equipments_categories.delete',
            ],
            // Clientes
            [
                'name' => 'Módulo de clientes',
                'guard_name' => 'clients',
            ],
            [
                'name' => 'Módulo de clientes - Crear',
                'guard_name' => 'clients.create',
            ],
            [
                'name' => 'Módulo de clientes - Leer',
                'guard_name' => 'clients.read',
            ],
            [
                'name' => 'Módulo de clientes - Editar',
                'guard_name' => 'clients.update',
            ],
            [
                'name' => 'Módulo de clientes - Eliminar',
                'guard_name' => 'clients.delete',
            ],
            // Inspecciones
            [
                'name' => 'Módulo de Inspecciones',
                'guard_name' => 'inspections',
            ],
            [
                'name' => 'Módulo de Inspecciones - Crear',
                'guard_name' => 'inspections.create',
            ],
            [
                'name' => 'Módulo de Inspecciones - Leer',
                'guard_name' => 'inspections.read',
            ],
            [
                'name' => 'Módulo de Inspecciones - Editar',
                'guard_name' => 'inspections.update',
            ],
            [
                'name' => 'Módulo de Inspecciones - Eliminar',
                'guard_name' => 'inspections.delete',
            ],
            // Fallas
            [
                'name' => 'Módulo de Fallas',
                'guard_name' => 'failures',
            ],
            [
                'name' => 'Módulo de Fallas - Crear',
                'guard_name' => 'failures.create',
            ],
            [
                'name' => 'Módulo de Fallas - Leer',
                'guard_name' => 'failures.read',
            ],
            [
                'name' => 'Módulo de Fallas - Editar',
                'guard_name' => 'failures.update',
            ],
            [
                'name' => 'Módulo de Fallas - Eliminar',
                'guard_name' => 'failures.delete',
            ],
            // Marcas
            [
                'name' => 'Módulo de marcas y modelos comerciales',
                'guard_name' => 'trademarks',
            ],
            [
                'name' => 'Módulo de marcas y modelos comerciales - Crear',
                'guard_name' => 'trademarks.create',
            ],
            [
                'name' => 'Módulo de marcas y modelos comerciales - Leer',
                'guard_name' => 'trademarks.read',
            ],
            [
                'name' => 'Módulo de marcas y modelos comerciales - Editar',
                'guard_name' => 'trademarks.update',
            ],
            [
                'name' => 'Módulo de marcas y modelos comerciales - Eliminar',
                'guard_name' => 'trademarks.delete',
            ],
            // Modelos
            [
                'name' => 'Módulo de modelos',
                'guard_name' => 'models',
            ],
            [
                'name' => 'Módulo de modelos - Crear',
                'guard_name' => 'models.create',
            ],
            [
                'name' => 'Módulo de modelos - Leer',
                'guard_name' => 'models.read',
            ],
            [
                'name' => 'Módulo de modelos - Editar',
                'guard_name' => 'models.update',
            ],
            [
                'name' => 'Módulo de modelos - Eliminar',
                'guard_name' => 'models.delete',
            ],
            // Aceites
            [
                'name' => 'Módulo de aceites',
                'guard_name' => 'oils',
            ],
            [
                'name' => 'Módulo de aceites - Crear',
                'guard_name' => 'oils.create',
            ],
            [
                'name' => 'Módulo de aceites - Leer',
                'guard_name' => 'oils.read',
            ],
            [
                'name' => 'Módulo de aceites - Editar',
                'guard_name' => 'oils.update',
            ],
            [
                'name' => 'Módulo de aceites - Eliminar',
                'guard_name' => 'oils.delete',
            ],
            // Proyectos
            [
                'name' => 'Módulo de proyectos',
                'guard_name' => 'projects',
            ],
            [
                'name' => 'Módulo de proyectos - Crear',
                'guard_name' => 'projects.create',
            ],
            [
                'name' => 'Módulo de proyectos - Leer',
                'guard_name' => 'projects.read',
            ],
            [
                'name' => 'Módulo de proyectos - Editar',
                'guard_name' => 'projects.update',
            ],
            [
                'name' => 'Módulo de proyectos - Eliminar',
                'guard_name' => 'projects.delete',
            ],

            // Roles y permisos
            [
                'name' => 'Módulo de roles y permisos',
                'guard_name' => 'roles',
            ],
            [
                'name' => 'Módulo de roles y permisos - Crear',
                'guard_name' => 'roles.create',
            ],
            [
                'name' => 'Módulo de roles y permisos - Leer',
                'guard_name' => 'roles.read',
            ],
            [
                'name' => 'Módulo de roles y permisos - Editar',
                'guard_name' => 'roles.update',
            ],
            [
                'name' => 'Módulo de roles y permisos - Eliminar',
                'guard_name' => 'roles.delete',
            ],
        ];
    }

    private function getUserPermissions(): array
    {
        return [
                'admin' => [
                    'users', 
                    'users.create',
                    'users.read',
                    'users.update',
                    'users.delete',
                    'equipments', 
                    'equipments.create',
                    'equipments.read',
                    'equipments.update',
                    'equipments.delete',
                    'equipments_categories',
                    'equipments_categories.create',
                    'equipments_categories.read',
                    'equipments_categories.update',
                    'equipments_categories.delete',
                    'clients',
                    'clients.create',
                    'clients.read',
                    'clients.update',
                    'clients.delete',
                    'inspections', 
                    'inspections.create',
                    'inspections.read',
                    'inspections.update',
                    'inspections.delete',
                    'failures',
                    'failures.create',
                    'failures.read',
                    'failures.update',
                    'failures.delete',
                    'trademarks', 
                    'trademarks.create',
                    'trademarks.read',
                    'trademarks.update',
                    'trademarks.delete',
                    'models',
                    'models.create',
                    'models.read',
                    'models.update',
                    'models.delete',
                    'oils', 
                    'oils.create',
                    'oils.read',
                    'oils.update',
                    'oils.delete',
                    'projects', 
                    'projects.create',
                    'projects.read',
                    'projects.update',
                    'projects.delete',
                    'roles',
                    'roles.create',
                    'roles.read',
                    'roles.update',
                    'roles.delete',
                ],
                'technical' => [
                    'inspections', 
                    'inspections.read',
                    'trademarks', 
                    'trademarks.read',
                    'failures',
                    'failures.read',
                    'projects', 
                    'projects.read',
                ],
                'client' => [
                    'projects', 
                    'projects.read',
                ],
            ];
    }
}
