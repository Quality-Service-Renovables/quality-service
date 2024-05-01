<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace Database\Seeders;

use App\Models\Clients\Client;
use App\Models\Rols\Rol;
use App\Models\Users\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getUsers() as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }
    }

    /**
     * Get the users array.
     */
    private function getUsers(): array
    {
        $client = Client::where('client_code', 'quality_service')->first();
        $rol = Rol::where('guard_name', 'admin')->first();

        return [
            [
                'uuid' => Str::uuid()->toString(),
                'name' => 'Quality Service',
                'email' => 'admin@quality-service.com',
                'password' => Hash::make('qsr.2024!'),
                'client_id' => $client->client_id,
                'rol_id' => $rol->id,
            ],
        ];
    }
}
