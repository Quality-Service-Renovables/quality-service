<?php /** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getCategories() as $category) {
            ServiceCategory::updateOrCreate(['ct_service_code' => $category['ct_service_code']], $category);
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
                'ct_service_uuid' => Str::uuid()->toString(),
                'ct_service' => 'Operación y Mantenimiento',
                'ct_service_code' => 'mantenimiento',
                'description' => 'Operación y Mantenimiento',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_service_uuid' => Str::uuid()->toString(),
                'ct_service' => 'Reparaciones',
                'ct_service_code' => 'reparacion',
                'description' => 'Reparaciones',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_service_uuid' => Str::uuid()->toString(),
                'ct_service' => 'Inspecciones',
                'ct_service_code' => 'inspeccion',
                'description' => 'Inspecciones',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'ct_service_uuid' => Str::uuid()->toString(),
                'ct_service' => 'Supervisión',
                'ct_service_code' => 'supervision',
                'description' => 'Supervisión',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
        ];
    }
}
