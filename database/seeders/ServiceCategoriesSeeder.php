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
            ServiceCategory::updateOrCreate(['service_category_code' => $category['service_category_code']], $category);
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
                'service_category_uuid' => Str::uuid()->toString(),
                'service_category' => 'Operación y Mantenimiento',
                'service_category_code' => 'mantenimiento',
                'description' => 'Operación y Mantenimiento',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'service_category_uuid' => Str::uuid()->toString(),
                'service_category' => 'Reparaciones',
                'service_category_code' => 'reparacion',
                'description' => 'Reparaciones',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'service_category_uuid' => Str::uuid()->toString(),
                'service_category' => 'Inspecciones',
                'service_category_code' => 'inspeccion',
                'description' => 'Inspecciones',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
            [
                'service_category_uuid' => Str::uuid()->toString(),
                'service_category' => 'Supervisión',
                'service_category_code' => 'supervision',
                'description' => 'Supervisión',
                'is_default' => true,
                'dependency' => null,
                'active' => true,
            ],
        ];
    }
}
