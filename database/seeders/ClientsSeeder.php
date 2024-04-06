<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach($this->getClients() as $client) {
            Client::updateOrCreate(['client_code' => $client['client_code']], $client);
        }
    }

    /**
     * Get an array of client data.
     *
     * @return array
     */
    private function getClients(): array
    {
        return [
            [
                'client_uuid' => Str::uuid()->toString(),
                'client' => 'Quality Service',
                'client_code' => 'quality_service',
                'legal_name' => 'Quality Service Renovables',
            ]
        ];
    }
}
