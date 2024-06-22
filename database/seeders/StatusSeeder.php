<?php

namespace Database\Seeders;

use App\Models\Status\Category;
use App\Models\Status\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getStatus() as $status) {
            Status::updateOrCreate(['status_code' => $status['status_code']], $status);
        }
    }

    /**
     * Get the status array.
     */
    private function getStatus(): array
    {
        $categories = Category::all();
        $equipmentCategory = $categories->where('ct_status_code', 'equipo')
            ->first()->ct_status_id;
        $projectCategory = $categories->where('ct_status_code', 'proyecto')
            ->first()->ct_status_id;
        $inspectionCategory = $categories->where('ct_status_code', 'inspeccion')
            ->first()->ct_status_id;

        return [
            [
                'status_uuid' => Str::uuid()->toString(),
                'status' => 'En Operación',
                'status_code' => 'operacion',
                'description' => 'Equipo actualmente operativo',
                'active' => true,
                'ct_status_id' => $equipmentCategory,
            ],
            [
                'status_uuid' => Str::uuid()->toString(),
                'status' => 'En Mantenimiento',
                'status_code' => 'mantenimiento',
                'description' => 'Equipo actualmente mantenimiento',
                'active' => true,
                'ct_status_id' => $equipmentCategory,
            ],
            [
                'status_uuid' => Str::uuid()->toString(),
                'status' => 'Baja',
                'status_code' => 'baja',
                'description' => 'Equipo dado de baja',
                'active' => true,
                'ct_status_id' => $equipmentCategory,
            ],
            [
                'status_uuid' => Str::uuid()->toString(),
                'status' => 'Proyecto Creado',
                'status_code' => 'proyecto_creado',
                'description' => 'Proyecto creado',
                'active' => true,
                'ct_status_id' => $projectCategory,
            ],
            [
                'status_uuid' => Str::uuid()->toString(),
                'status' => 'Proyecto Asignado',
                'status_code' => 'proyecto_asignado',
                'description' => 'Proyecto asignado',
                'active' => true,
                'ct_status_id' => $projectCategory,
            ],
            [
                'status_uuid' => Str::uuid()->toString(),
                'status' => 'Proyecto Inciado',
                'status_code' => 'proyecto_iniciado',
                'description' => 'Proyecto inicializado',
                'active' => true,
                'ct_status_id' => $projectCategory,
            ],
            [
                'status_uuid' => Str::uuid()->toString(),
                'status' => 'Proyecto Finalizado',
                'status_code' => 'proyecto_finalizado',
                'description' => 'Proyecto finalizado',
                'active' => true,
                'ct_status_id' => $projectCategory,
            ],
            [
                'status_uuid' => Str::uuid()->toString(),
                'status' => 'En Proyecto De Validación',
                'status_code' => 'proyecto_validado',
                'description' => 'En Proyecto de validación',
                'active' => true,
                'ct_status_id' => $projectCategory,
            ],
            [
                'status_uuid' => Str::uuid()->toString(),
                'status' => 'Proyecto Cerrado',
                'status_code' => 'proyecto_cerrado',
                'description' => 'Proyecto finalizado o ciclo cerrado',
                'active' => true,
                'ct_status_id' => $projectCategory,
            ],
            [
                'status_uuid' => Str::uuid()->toString(),
                'status' => 'Proyecto Cancelado',
                'status_code' => 'proyecto_cancelado',
                'description' => 'Proyecto cancelado',
                'active' => true,
                'ct_status_id' => $projectCategory,
            ],
/*            [
                'status_uuid' => Str::uuid()->toString(),
                'status' => 'Inspección iniciada',
                'status_code' => 'inspeccion_iniciada',
                'description' => 'Inspección inicializada',
                'active' => true,
                'ct_status_id' => $inspectionCategory,
            ],
            [
                'status_uuid' => Str::uuid()->toString(),
                'status' => 'Inspección en Curso',
                'status_code' => 'inspeccion_en_curso',
                'description' => 'En Proyecto de inspección',
                'active' => true,
                'ct_status_id' => $inspectionCategory,
            ],
            [
                'status_uuid' => Str::uuid()->toString(),
                'status' => 'Inspección Pausada',
                'status_code' => 'inspeccion_pausada',
                'description' => 'Inspección pausada por algún tipo de impedimento',
                'active' => true,
                'ct_status_id' => $inspectionCategory,
            ],
            [
                'status_uuid' => Str::uuid()->toString(),
                'status' => 'Inspección Finalizada',
                'status_code' => 'inspeccion_finalizada',
                'description' => 'Inspección finalizada lista para validar',
                'active' => true,
                'ct_status_id' => $inspectionCategory,
            ],
            [
                'status_uuid' => Str::uuid()->toString(),
                'status' => 'Inspección Validadad',
                'status_code' => 'inspeccion_validada',
                'description' => 'Inspección validada y accesible por el cliente',
                'active' => true,
                'ct_status_id' => $inspectionCategory,
            ],*/
        ];
    }
}
