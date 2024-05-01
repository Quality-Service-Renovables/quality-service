<?php

namespace Database\Seeders;

use App\Models\Application\Version;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VersionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getVersions() as $version) {
            Version::updateOrCreate($version);
        }
    }

    /**
     * Get an array of client data.
     */
    private function getVersions(): array
    {
        return [
            [
                'application_version_uuid' => Str::uuid()->toString(),
                'version' => '1.0.0',
            ],
        ];
    }
}
