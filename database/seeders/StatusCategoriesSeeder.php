<?php

namespace Database\Seeders;

use App\Models\Status\Category;
use App\Models\Status\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StatusCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getStatus() as $status) {
            Category::updateOrCreate(['ct_status_code' => $status['ct_status_code']], $status);
        }
    }

    /**
     * Get the status array.
     *
     * @return array
     */
    private function getStatus(): array
    {
        return [
            [
                'ct_status_uuid' => Str::uuid()->toString(),
                'ct_status' => 'Proyectos',
                'ct_status_code' => 'proyecto',
                'description' => 'Estados para proyectos',
                'active' => true,
            ],
            [
                'ct_status_uuid' => Str::uuid()->toString(),
                'ct_status' => 'Inspección',
                'ct_status_code' => 'inspeccion',
                'description' => 'Estados correspondientes a inspecciones',
                'active' => true,
            ],
            [
                'ct_status_uuid' => Str::uuid()->toString(),
                'ct_status' => 'Equipos',
                'ct_status_code' => 'equipo',
                'description' => 'Estados correspondientes a equipos',
                'active' => true,
            ],
        ];
    }
}
