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
