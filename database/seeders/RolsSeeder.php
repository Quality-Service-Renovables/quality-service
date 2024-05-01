<?php

namespace Database\Seeders;

use App\Models\Rols\Rol;
use Illuminate\Database\Seeder;

class RolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getRols() as $rol) {
            Rol::updateOrCreate(['guard_name' => $rol['guard_name']], $rol);
        }
    }

    private function getRols(): array
    {
        return [
            [
                'name' => 'Admin',
                'guard_name' => 'admin',
            ],
            [
                'name' => 'Client',
                'guard_name' => 'client',
            ],
            [
                'name' => 'Técnico',
                'guard_name' => 'tecnic',
            ],
        ];
    }

}
