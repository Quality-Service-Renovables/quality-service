<?php

namespace Database\Seeders;

use App\Models\Inspections\CtRisk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RisksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->risks() as $risk) {
            CtRisk::updateOrCreate(['ct_risk' => $risk['ct_risk']], $risk);
        }
    }

    private function risks(): array
    {
        return [
            [
                'ct_risk_uuid' => Str::uuid()->toString(),
                'ct_risk' => 'Moderado',
                'ct_description' => 'Componente o elemento en el que ya se aprecian daños o defectos desarrollados. Estos defectos evolucionarán con seguridad a una categoría superior y pueden poner en peligro a medio plazo la integridad de la máquina. Sin embargo, esto no impide el funcionamiento eficaz de la máquina. Debe realizarse un seguimiento de la máquina de forma que se inspeccione nuevamente en un plazo no superior a 6 meses.',
                'ct_description_secondary' => null,
                'ct_color' => '#fc9',
            ],
            [
                'ct_risk_uuid' => Str::uuid()->toString(),
                'ct_risk' => 'Peligro',
                'ct_description' => 'Existen daños severos en algún componente de la máquina que impiden o afectan gravemente a su buen funcionamiento. De seguir en funcionamiento, con seguridad se producirá un fallo catastrófico que puede dañar uno o más componentes, ocasionar daños a las personas o al medioambiente. Debe ser reparado de forma inmediata.',
                'ct_description_secondary' => null,
                'ct_color' => '#ff0001',
            ],
            [
                'ct_risk_uuid' => Str::uuid()->toString(),
                'ct_risk' => 'Leve',
                'ct_description' => 'Componente o elemento en el que se han apreciado daños o defectos leves. No impide el funcionamiento normal del aerogenerador, pero puede evolucionar de forma negativa. Debe realizarse un seguimiento de la máquina de forma que se inspeccione nuevamente en un plazo no superior a 1 año.',
                'ct_description_secondary' => null,
                'ct_color' => '#fffd99',
            ],
            [
                'ct_risk_uuid' => Str::uuid()->toString(),
                'ct_risk' => 'Normal',
                'ct_description' => 'Componente o elemento en buen estado, apto para seguir funcionando de manera normal y eficiente. En ocasiones puede observarse un desgaste propio del funcionamiento normal de la máquina.',
                'ct_description_secondary' => null,
                'ct_color' => '#9c0',
            ],
            [
                'ct_risk_uuid' => Str::uuid()->toString(),
                'ct_risk' => 'Grave',
                'ct_description' => 'Componente o elemento en el que se aprecian con claridad daños o defectos plenamente desarrollados. La máquina puede seguir funcionando, pero ello ocasionará un agravamiento muy rápido de los defectos presentes. Debe realizarse una vigilancia estrecha de la máquina de forma que se inspeccione con una periodicidad mensual para comprobar su evolución y poder anticiparse al fallo del componente.',
                'ct_description_secondary' => null,
                'ct_color' => '#ff9901',
            ],
            // Add more risk data as needed
        ];
    }
}
