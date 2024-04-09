<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            ClientsSeeder::class,
            StatusSeeder::class,
            UsersSeeder::class,
            VersionsSeeder::class,
        ]);
    }
}
