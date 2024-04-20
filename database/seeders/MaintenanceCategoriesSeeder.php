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
            MaintenanceCategory::updateOrCreate(['maintenance_category_code' => $category['maintenance_category_code']], $category);
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
                'maintenance_category_uuid' => Str::uuid()->toString(),
                'maintenance_category' => 'Mantenimiento Preventivo',
                'maintenance_category_code' => 'mantenimiento_preventivo',
                'description' => 'Mantenimiento Preventivo',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'maintenance_category_uuid' => Str::uuid()->toString(),
                'maintenance_category' => 'Mantenimiento pequeño correctivo',
                'maintenance_category_code' => 'mantenimiento_pequeno_correctivo',
                'description' => 'Mantenimiento pequeño correctivo',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'maintenance_category_uuid' => Str::uuid()->toString(),
                'maintenance_category' => 'Grandes correctivos',
                'maintenance_category_code' => 'grandes_correctivos',
                'description' => 'Grandes correctivos de palas, eje principal, multiplicadora, generador y transformador',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'maintenance_category_uuid' => Str::uuid()->toString(),
                'maintenance_category' => 'Alineación de generadores',
                'maintenance_category_code' => 'alineacion_generador',
                'description' => 'Alineación de generadores',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'maintenance_category_uuid' => Str::uuid()->toString(),
                'maintenance_category' => 'Tensionado y reapriete de uniones en máquina',
                'maintenance_category_code' => 'tensionado_reapriete_uniones_maquina',
                'description' => 'Tensionado y reapriete de uniones en máquina',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'maintenance_category_uuid' => Str::uuid()->toString(),
                'maintenance_category' => 'Mantenimiento predictivo',
                'maintenance_category_code' => 'mantenimiento_predictivo',
                'description' => 'Mantenimiento predictivo (endoscopia, análisis vibraciones)',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'maintenance_category_uuid' => Str::uuid()->toString(),
                'maintenance_category' => 'Cambio y análisis de aceites',
                'maintenance_category_code' => 'cambio_analisis_aceites',
                'description' => 'Cambio y análisis de aceites, anticongelantes, grasas y filtros.',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'maintenance_category_uuid' => Str::uuid()->toString(),
                'maintenance_category' => 'Vibraciones',
                'maintenance_category_code' => 'vibraciones',
                'description' => 'Vibraciones (toma de datos y análisis de resultados)',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'maintenance_category_uuid' => Str::uuid()->toString(),
                'maintenance_category' => 'Gestión de stock de repuestos',
                'maintenance_category_code' => 'gestion_stock_repuestos',
                'description' => 'Gestión de stock de repuestos y consumibles en almacenes de parques eólicos',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'maintenance_category_uuid' => Str::uuid()->toString(),
                'maintenance_category' => 'Limpieza de torres',
                'maintenance_category_code' => 'limpieza_torres',
                'description' => 'Limpieza de torres',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
        ];
    }
}
