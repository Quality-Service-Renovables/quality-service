<h3>Equipo</h3>
<table class="inspection-table">
    @php $equipment = json_decode($inspection->equipment_fields_report); @endphp
    @foreach($equipment as $key => $value)
        <tr>
            <td><strong>{{ucfirst($value->name)}}: </strong></td>
            <td>{{$value->value}}</td>
        </tr>
    @endforeach
</table>
{{--<h3>Digrama Esquemático</h3>
<img src="{{$inspection->equipment->equipment_diagram}}" width="45%" height="25%" style="margin: 10px">-->
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
