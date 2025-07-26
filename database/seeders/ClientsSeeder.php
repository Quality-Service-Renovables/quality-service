<?php
/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpUndefinedMethodInspection */

namespace Database\Seeders;

use App\Models\Clients\Client;
use App\Models\Clients\Config;
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
            $currentClient = Client::updateOrCreate(['client_code' => $client['client_code']], $client);
            Config::updateOrCreate(['client_id' => $currentClient->client_id], [
                'client_configuration_uuid' => Str::uuid()->toString(),
                'client_id' => $currentClient->client_id,
            ]);
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
                'client' => 'QSR Solutions',
                'client_code' => 'quality_service',
                'legal_name' => 'QSR Solutions S. de R.L de C.V',
                'address' => 'C/ Mario Mazún S/N, C/Esq. Telesecundaria, Col. Ensenada la Ventosa, Salina Cruz, Oax.',
                'zip_code' => '70680',
                'phone' => '+52 971 208 4735',
                'phone_office' => '+52 971 208 4735',
                'open_time' => '08:00:00',
                'close_time' => '16:00:00',
                'office_days' => 'Lunes a Sábado',
                'website' => 'https://qsr.mx/',
                'email' => 'info@qsr.mx',
            ],
        ];
    }
}
