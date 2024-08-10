<div class="section">
    <h3 class="primary-color uppercase">3. INFORMACIÓN</h3>
    <h3 class="primary-color uppercase">3.1 INFORMACIÓN GENERAL</h3>
    <table>
        <tbody>
            <tr class="text-center">
                <td class="w-50 bg-gray border">Información:</td>
                <td class="w-50 bg-gray border">Datos</td>
            </tr>
            <tr>
                <td class="border">Cliente</td>
                <td class="border">{{ $inspection->client->client }}</td>
            </tr>
            <tr>
                <td class="border">Fecha de inspección</td>
                <td class="border">{{ $inspection->created_at }}</td>
            </tr>
            <tr>
                <td class="border">Ubidación del sitio</td>
                <td class="border">{{ $inspection->location }}</td>
            </tr>
            <tr>
                <td class="border">Tipo Inspección</td>
                <td class="border">{{ $inspection->category->ct_inspection }}</td>
            </tr>
            <tr>
                <td class="border">Equipos utilizados en la inspección</td>
                <td class="border">
                    @foreach ($inspection->inspectionEquipments as $inspectionEquipment)
                        {{ $inspectionEquipment->equipment->equipment }}.<br>
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <h3 class="primary-color uppercase">3.1 INFORMACIÓN DEL EQUIPO</h3>
    @if($inspection->equipment_fields_report != null && count(json_decode($inspection->equipment_fields_report)))
    <table>
        <tbody>
            <tr class="text-center">
                <td class="w-50 bg-gray border">Información:</td>
                <td class="w-50 bg-gray border">Datos</td>
            </tr>
            @php $equipment = json_decode($inspection->equipment_fields_report); @endphp
            @foreach($equipment as $key => $value)
                @if($value->value)
                <tr>
                    <td class="border">{{ucfirst($value->name)}}</td>
                    <td class="border">{{$value->value}}</td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    @else
    <table>
        <tbody>
            <tr class="text-center">
                <td class="w-50 bg-gray border">Información:</td>
                <td class="w-50 bg-gray border">Datos</td>
            </tr>
            <tr>
                <td colspan="2" class="border">Por definir</td>
            </tr>
        </tbody>
    @endif
</div>
