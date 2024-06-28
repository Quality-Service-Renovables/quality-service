<?php
/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creamos los permisos
        foreach ($this->getPermissions() as $permission) {
            Permission::updateOrCreate(['name' => $permission['name'], 'description' => $permission['description']]);
        }

        // Asignamos los permisos a los roles
        foreach ($this->getPermissionsByRol() as $rol => $permissions) {
            $role = Role::where('name', $rol)->first();
            $role->syncPermissions($permissions);
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
                'description' => 'Módulo de usuarios',
                'name' => 'users',
            ],
            [
                'description' => 'Módulo de usuarios - Crear',
                'name' => 'users.create',
            ],
            [
                'description' => 'Módulo de usuarios - Leer',
                'name' => 'users.read',
            ],
            [
                'description' => 'Módulo de usuarios - Editar',
                'name' => 'users.update',
            ],
            [
                'description' => 'Módulo de usuarios - Eliminar',
                'name' => 'users.delete',
            ],
            // Equipos
            [
                'description' => 'Módulo de Equipos',
                'name' => 'equipments',
            ],
            [
                'description' => 'Módulo de Equipos - Crear',
                'name' => 'equipments.create',
            ],
            [
                'description' => 'Módulo de Equipos - Leer',
                'name' => 'equipments.read',
            ],
            [
                'description' => 'Módulo de Equipos - Editar',
                'name' => 'equipments.update',
            ],
            [
                'description' => 'Módulo de Equipos - Eliminar',
                'name' => 'equipments.delete',
            ],
            // Categorias de equipos
            [
                'description' => 'Módulo de Categorías de Equipos',
                'name' => 'equipments_categories',
            ],
            [
                'description' => 'Módulo de Categorías de Equipos - Crear',
                'name' => 'equipments_categories.create',
            ],
            [
                'description' => 'Módulo de Categorías de Equipos - Leer',
                'name' => 'equipments_categories.read',
            ],
            [
                'description' => 'Módulo de Categorías de Equipos - Editar',
                'name' => 'equipments_categories.update',
            ],
            [
                'description' => 'Módulo de Categorías de Equipos - Eliminar',
                'name' => 'equipments_categories.delete',
            ],
            // Clientes
            [
                'description' => 'Módulo de clientes',
                'name' => 'clients',
            ],
            [
                'description' => 'Módulo de clientes - Crear',
                'name' => 'clients.create',
            ],
            [
                'description' => 'Módulo de clientes - Leer',
                'name' => 'clients.read',
            ],
            [
                'description' => 'Módulo de clientes - Editar',
                'name' => 'clients.update',
            ],
            [
                'description' => 'Módulo de clientes - Eliminar',
                'name' => 'clients.delete',
            ],
            // Inspecciones
            [
                'description' => 'Módulo de Inspecciones',
                'name' => 'inspections',
            ],
            [
                'description' => 'Módulo de Inspecciones - Crear',
                'name' => 'inspections.create',
            ],
            [
                'description' => 'Módulo de Inspecciones - Leer',
                'name' => 'inspections.read',
            ],
            [
                'description' => 'Módulo de Inspecciones - Editar',
                'name' => 'inspections.update',
            ],
            [
                'description' => 'Módulo de Inspecciones - Eliminar',
                'name' => 'inspections.delete',
            ],
            // Fallas
            [
                'description' => 'Módulo de Fallas',
                'name' => 'failures',
            ],
            [
                'description' => 'Módulo de Fallas - Crear',
                'name' => 'failures.create',
            ],
            [
                'description' => 'Módulo de Fallas - Leer',
                'name' => 'failures.read',
            ],
            [
                'description' => 'Módulo de Fallas - Editar',
                'name' => 'failures.update',
            ],
            [
                'description' => 'Módulo de Fallas - Eliminar',
                'name' => 'failures.delete',
            ],
            // Marcas
            [
                'description' => 'Módulo de marcas y modelos comerciales',
                'name' => 'trademarks',
            ],
            [
                'description' => 'Módulo de marcas y modelos comerciales - Crear',
                'name' => 'trademarks.create',
            ],
            [
                'description' => 'Módulo de marcas y modelos comerciales - Leer',
                'name' => 'trademarks.read',
            ],
            [
                'description' => 'Módulo de marcas y modelos comerciales - Editar',
                'name' => 'trademarks.update',
            ],
            [
                'description' => 'Módulo de marcas y modelos comerciales - Eliminar',
                'name' => 'trademarks.delete',
            ],
            // Modelos
            [
                'description' => 'Módulo de modelos',
                'name' => 'models',
            ],
            [
                'description' => 'Módulo de modelos - Crear',
                'name' => 'models.create',
            ],
            [
                'description' => 'Módulo de modelos - Leer',
                'name' => 'models.read',
            ],
            [
                'description' => 'Módulo de modelos - Editar',
                'name' => 'models.update',
            ],
            [
                'description' => 'Módulo de modelos - Eliminar',
                'name' => 'models.delete',
            ],
            // Aceites
            [
                'description' => 'Módulo de aceites',
                'name' => 'oils',
            ],
            [
                'description' => 'Módulo de aceites - Crear',
                'name' => 'oils.create',
            ],
            [
                'description' => 'Módulo de aceites - Leer',
                'name' => 'oils.read',
            ],
            [
                'description' => 'Módulo de aceites - Editar',
                'name' => 'oils.update',
            ],
            [
                'description' => 'Módulo de aceites - Eliminar',
                'name' => 'oils.delete',
            ],
            // Proyectos
            [
                'description' => 'Módulo de proyectos',
                'name' => 'projects',
            ],
            [
                'description' => 'Módulo de proyectos - Crear',
                'name' => 'projects.create',
            ],
            [
                'description' => 'Módulo de proyectos - Leer',
                'name' => 'projects.read',
            ],
            [
                'description' => 'Módulo de proyectos - Editar',
                'name' => 'projects.update',
            ],
            [
                'description' => 'Módulo de proyectos - Eliminar',
                'name' => 'projects.delete',
            ],
            [
                'description' => 'Módulo de proyectos - Finalizar proyecto',
                'name' => 'projects.finalize',
            ],
            [
                'description' => 'Módulo de proyectos - Validar proyecto',
                'name' => 'projects.validate',
            ],
            [
                'description' => 'Módulo de proyectos - Cerrar proyecto',
                'name' => 'projects.close',
            ],
            [
                'description' => 'Módulo de proyectos - Cancelar proyecto',
                'name' => 'projects.cancel',
            ],

            // Roles y permisos
            [
                'description' => 'Módulo de roles y permisos',
                'name' => 'roles',
            ],
            [
                'description' => 'Módulo de roles y permisos - Crear',
                'name' => 'roles.create',
            ],
            [
                'description' => 'Módulo de roles y permisos - Leer',
                'name' => 'roles.read',
            ],
            [
                'description' => 'Módulo de roles y permisos - Editar',
                'name' => 'roles.update',
            ],
            [
                'description' => 'Módulo de roles y permisos - Eliminar',
                'name' => 'roles.delete',
            ],
        ];
    }

    private function getPermissionsByRol(): array
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
                    'projects.finalize',
                    'projects.validate',
                    'projects.close',
                    'projects.cancel',
                    'roles',
                    'roles.create',
                    'roles.read',
                    'roles.update',
                    'roles.delete',
                ],
                'tecnico' => [
                    'inspections', 
                    'inspections.read',
                    'trademarks', 
                    'trademarks.read',
                    'failures',
                    'failures.read',
                    'projects', 
                    'projects.read',
                    'projects.update',
                    'projects.finalize',
                ],
                'cliente' => [
                    'projects', 
                    'projects.read',
                ],
            ];
    }
}
