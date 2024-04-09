<?php
/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

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
        foreach ($this->getClients() as $client) {
            Client::updateOrCreate(['client_code' => $client['client_code']], $client);
        }
    }

    /**
     * Get an array of client data.
     */
    private function getClients(): array
    {
        return [
            [
                'client_uuid' => Str::uuid()->toString(),
                'client' => 'Quality Service',
                'client_code' => 'quality_service',
                'legal_name' => 'Quality Service Renovables S. de R.L de C.V',
                'address' => 'C./Col Petrolera Plaza 21 s/c n.4 Salina Cruz Oaxaca Mex.',
                'zip_code' => '70620',
                'phone' => '+52 971 208 4735',
                'phone_office' => '+52 971 133 5323',
                'open_time' => '08:00:00',
                'close_time' => '16:00:00',
                'office_days' => 'Lunes a Sábado',
                'website' => 'https://qualityservicerenovables.com.mx/',
                'email' => 'jl.berdeal@qualityservicerenovables.com.mx',
            ],
        ];
    }
}
