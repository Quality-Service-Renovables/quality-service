<div style="margin-top: 200px;">
<h3>1.1 Información</h3>
<table class="inspection-table">
    <thead>
        <th colspan="2" style="text-align: left;">{{ $inspection->project->project_name }}</th>
    </thead>
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
                @foreach($inspection->inspectionEquipments as $inspectionEquipment)
                    {{ $inspectionEquipment->equipment->equipment }}.<br>
                @endforeach
            </td>
        </tr>
        <tr>
            <td>Inspector:</td>
            <td>
                @foreach($inspection->project->employees as $employee)
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
{{--Multiplicadora--}}
<table class="inspection-table">
    <thead>
        <th colspan="2" style="text-align: left;">Ficha Técnica</th>
    </thead>
    <tbody>
        @foreach($inspection->fields as $field)
            <tr>
                <td>{{ $field->name }}</td>
                <td>{{ $field->value }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
