<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class RolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin', 'description' => 'Administrador']);
        Role::create(['name' => 'tecnico', 'description' => 'Técnico']);
        Role::create(['name' => 'cliente', 'description' => 'Cliente']);
    }
}
