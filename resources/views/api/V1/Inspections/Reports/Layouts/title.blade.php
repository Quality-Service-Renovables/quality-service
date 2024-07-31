<div style="margin-top: 200px;">
<h1>1.1 Información</h1>
<table>
    <thead>
        <th>Inspección</th>
    </thead>
    <tbody>
        <tr>
            <td>Fecha Inspección:</td>
            <td>{{ $inspection->created_at }}</td>
        </tr>
        <tr>
            <td>Tipo Inspección:</td>
            <td></td>
        </tr>
        <tr>
            <td>Equipo Inspección:</td>
            <td></td>
        </tr>
        <tr>
            <td>Inspector:</td>
            <td></td>
        </tr>
        <tr>
            <td>Diagnóstico:</td>
            <td>{{ $inspection->diagnosis->name }}</td>
        </tr>
    </tbody>
</table>
{{--Emplazamiento--}}
<table>
    <thead>
        <th>Emplazamiento</th>
    </thead>
    <tbody>
        <tr>
            <td>Nombre del Sitio:</td>
            <td></td>
        </tr>
        <tr>
            <td>Ubicación:</td>
            <td>{{ $inspection->location }}</td>
        </tr>
        <tr>
            <td>Número de Máquina:</td>
            <td></td>
        </tr>
    </tbody>
</table>
{{--Multiplicadora--}}
<table>
    <thead>
        <th>Multiplicadora</th>
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
