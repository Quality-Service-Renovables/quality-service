<h3>Equipo</h3>
<table class="inspection-table">
    <tr>
        <td><strong>Nombre: </strong></td>
        <td colspan="2">{{$inspection->equipment->equipment}}</td>
    </tr>
    <tr>
        <td><strong>Descripción: </strong></td>
        <td colspan="2">{{$inspection->equipment->description}}</td>
    </tr>
    <tr>
        <td><strong>Ubicación: </strong></td>
        <td colspan="2">{{$inspection->location}}</td>
    </tr>
    <tr>
        <td><strong>Fabricante del equipo: </strong></td>
        <td>{{$inspection->equipment->model->trademark->trademark}}</td>
        <td><strong>Año: </strong>{{$inspection->equipment->manufacture_date}}</td>
    </tr>
    <tr>
        <td rowspan="2"><strong>Datos del equipo: </strong></td>
        <td><strong>Modelo: </strong>{{$inspection->equipment->model->trademark_model}}</td>
        <td><strong>Serie: </strong>{{$inspection->equipment->serial_number}}</td>
    </tr>
    <tr>
        <td><strong>Horas Operación: </strong>{{$inspection->equipment->work_hours}}</td>
        <td><strong>Energía Producida: </strong>{{$inspection->equipment->energy_produced}}</td>
    </tr>
</table>
<h3>Digrama Esquemático</h3>
<img src="{{$inspection->equipment->equipment_diagram}}" width="45%" height="25%" style="margin: 10px">
{{--    $pathAddress = asset('/').$inspection->equipment->equipment_diagram;--}}
{{--  RESUMEN DE INSPECCIÓN  --}}
<h3>Resumen de Inspección</h3>
<p style="text-align: justify-all">{!! $inspection->resume !!}</p>
{{--  EQUIPO INSPECCIÓN  --}}
<h3>Equipos Utilizados En La Inspección</h3>
<table>
    @foreach($inspection->inspectionEquipments as $equipmentsInspection)
        <tr>
            <td><strong>Equipo: </strong>{{$equipmentsInspection->equipment->equipment}}</td>
            <td><strong>Descripción: </strong><small>{{$equipmentsInspection->equipment->description}}</small></td>
        </tr>
    @endforeach
</table>
