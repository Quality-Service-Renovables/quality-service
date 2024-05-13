<?php /** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace Database\Seeders;

use App\Models\Maintenances\MaintenanceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MaintenanceCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getCategories() as $category) {
            MaintenanceCategory::updateOrCreate(['ct_maintenance_code' => $category['ct_maintenance_code']], $category);
        }
    }

    /**
     * Get the status array.
     *
     * @return array
     */
    private function getCategories(): array
    {
        return [
            [
                'ct_maintenance_uuid' => Str::uuid()->toString(),
                'ct_maintenance' => 'Mantenimiento Preventivo',
                'ct_maintenance_code' => 'mantenimiento_preventivo',
                'description' => 'Mantenimiento Preventivo',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_maintenance_uuid' => Str::uuid()->toString(),
                'ct_maintenance' => 'Mantenimiento pequeño correctivo',
                'ct_maintenance_code' => 'mantenimiento_pequeno_correctivo',
                'description' => 'Mantenimiento pequeño correctivo',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_maintenance_uuid' => Str::uuid()->toString(),
                'ct_maintenance' => 'Grandes correctivos',
                'ct_maintenance_code' => 'grandes_correctivos',
                'description' => 'Grandes correctivos de palas, eje principal, multiplicadora, generador y transformador',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_maintenance_uuid' => Str::uuid()->toString(),
                'ct_maintenance' => 'Alineación de generadores',
                'ct_maintenance_code' => 'alineacion_generador',
                'description' => 'Alineación de generadores',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_maintenance_uuid' => Str::uuid()->toString(),
                'ct_maintenance' => 'Tensionado y reapriete de uniones en máquina',
                'ct_maintenance_code' => 'tensionado_reapriete_uniones_maquina',
                'description' => 'Tensionado y reapriete de uniones en máquina',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_maintenance_uuid' => Str::uuid()->toString(),
                'ct_maintenance' => 'Mantenimiento predictivo',
                'ct_maintenance_code' => 'mantenimiento_predictivo',
                'description' => 'Mantenimiento predictivo (endoscopia, análisis vibraciones)',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_maintenance_uuid' => Str::uuid()->toString(),
                'ct_maintenance' => 'Cambio y análisis de aceites',
                'ct_maintenance_code' => 'cambio_analisis_aceites',
                'description' => 'Cambio y análisis de aceites, anticongelantes, grasas y filtros.',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_maintenance_uuid' => Str::uuid()->toString(),
                'ct_maintenance' => 'Vibraciones',
                'ct_maintenance_code' => 'vibraciones',
                'description' => 'Vibraciones (toma de datos y análisis de resultados)',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_maintenance_uuid' => Str::uuid()->toString(),
                'ct_maintenance' => 'Gestión de stock de repuestos',
                'ct_maintenance_code' => 'gestion_stock_repuestos',
                'description' => 'Gestión de stock de repuestos y consumibles en almacenes de parques eólicos',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_maintenance_uuid' => Str::uuid()->toString(),
                'ct_maintenance' => 'Limpieza de torres',
                'ct_maintenance_code' => 'limpieza_torres',
                'description' => 'Limpieza de torres',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
        ];
    }
}
