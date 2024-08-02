<div style="margin-top: 200px;">
    <h2 style="text-align: left;">{{ $inspection->project->title_report }}</h2>

    @if ($inspection->client->logo)
        <img src="{{ $inspection->client->logo }}" width="300px" height="300px" alt="{{ $inspection->client->client }}">
    @endif
    <p>{{ $inspection->client->client }}</p>
    <p style="color: gray">{{ $inspection->client->legal_name }}</p>
    <p style="color: gray">{{ date('d M Y') }}</p>
    <p style="font-size: 16px;"><small>{!! $inspection->category->description !!}</small></p>

    <h3>1.1 Información</h3>
    <table class="inspection-table">
        <tbody>
            <tr>
                <td>Fecha Inspección:</td>
                <td>{{ $inspection->created_at }}</td>
            </tr>
            <tr>
                <td>Tipo Inspección:</td>
                <td>{{ $inspection->category->ct_inspection }}</td>
            </tr>
            <tr>
                <td>Equipo Inspección:</td>
                <td>
                    @foreach ($inspection->inspectionEquipments as $inspectionEquipment)
                        {{ $inspectionEquipment->equipment->equipment }}.<br>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td>Inspector:</td>
                <td>
                    @foreach ($inspection->project->employees as $employee)
                        {{ $employee->user->name }}.<br>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td>Diagnóstico:</td>
                <td>{{ $inspection->diagnosis->name ?? '' }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    {{-- Multiplicadora --}}
    <table class="inspection-table">
        <thead>
            <th colspan="2" style="text-align: left;">Ficha Técnica</th>
        </thead>
        <tbody>
            @foreach ($inspection->fields as $field)
                <tr>
                    <td>{{ $field->name }}</td>
                    <td>{{ $field->value }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
