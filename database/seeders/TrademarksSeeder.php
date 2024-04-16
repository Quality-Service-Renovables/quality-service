<?php

namespace Database\Seeders;

use App\Models\Trademarks\Trademark;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TrademarksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->getTrademarks() as $trademark) {
            Trademark::updateOrCreate(['trademark_code' => $trademark['trademark_code']], $trademark);
        }
    }

    /**
     * Get the array of trademarks.
     *
     * @return array
     */
    private function getTrademarks(): array
    {
        return [
            [
                'trademark_uuid' => Str::uuid()->toString(),
                'trademark' => 'Generic',
                'trademark_code' => 'generic',
                'active' => true,
            ],
            [
                'trademark_uuid' => Str::uuid()->toString(),
                'trademark' => 'Winergy',
                'trademark_code' => 'winergy',
                'active' => true,
            ],
        ];
    }
}
