<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
     *
     * @return array
     */
    private function getStatus(): array
    {
        return [
            [
                'status_uuid' => Str::uuid()->toString(),
                'status' => 'En Operación',
                'status_code' => 'operación',
                'description' => 'Equipo actualmente operativo',
                'active' => true,
            ],
            [
                'status_uuid' => Str::uuid()->toString(),
                'status' => 'En Mantenimiento',
                'status_code' => 'mantenimiento',
                'description' => 'Equipo actualmente mantenimiento',
                'active' => true,
            ],
            [
                'status_uuid' => Str::uuid()->toString(),
                'status' => 'Baja',
                'status_code' => 'baja',
                'description' => 'Equipo dado de baja',
                'active' => true,
            ],
        ];
    }
}
