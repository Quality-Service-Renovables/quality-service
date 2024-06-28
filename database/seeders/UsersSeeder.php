<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace Database\Seeders;

use App\Models\Clients\Client;
use App\Models\AuthGuards\Role;
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
            User::updateOrCreate(
                ['email' => $user['email']], 
                [
                    'uuid' => $user['uuid'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => $user['password'],
                    'client_id' => $user['client_id'],
                ]
            )->assignRole($user['rol']);
        }
    }

    /**
     * Get the users array.
     */
    private function getUsers(): array
    {
        $client = Client::where('client_code', 'quality_service')->first();

        return [
            [
                'uuid' => Str::uuid()->toString(),
                'name' => 'Quality Service',
                'email' => 'admin@qsr.mx',
                'password' => Hash::make('qsr.2024!'),
                'client_id' => $client->client_id,
                'rol' => 'admin'
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'name' => 'Cliente',
                'email' => 'cliente@qsr.mx',
                'password' => Hash::make('qsr.2024!'),
                'client_id' => $client->client_id,
                'rol' => 'cliente'
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'name' => 'Juan M. Aburto Toledo',
                'email' => 'jburto@qsr.mx',
                'password' => Hash::make('qsr.2024!'),
                'client_id' => $client->client_id,
                'rol' => 'tecnico'
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'name' => 'Francisco Alan Pineda Toledo',
                'email' => 'fpineda@qsr.mx',
                'password' => Hash::make('qsr.2024!'),
                'client_id' => $client->client_id,
                'rol' => 'tecnico'
            ],
        ];
    }
}
