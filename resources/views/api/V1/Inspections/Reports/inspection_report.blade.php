<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <title inertia>{{ config('app.name', 'Quality Service Renovables') }}</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' />
    <meta name="theme-color" content="#c40000" />
    <meta NAME="keywords" CONTENT="quality, service, renovables, eólico, energía" />
    <meta NAME="description" CONTENT="Servicios profesionales técnicos industriales, especializados en mecatrónica dentro de sector eólico y las nuevas fuentes de energías renovables" />
    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="#c40000">
    <meta name="apple-mobile-web-app-title" content="QSR App">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        table{
            border: 1px solid black;
            border-collapse: collapse;
        }
        table tr td {
            border: 1px solid black;
        }
    </style>
</head>

<body class="font-sans antialiased">
    @php
        //dd($inspection->category->sections);
    @endphp
    {{--  EQUIPO  --}}
    <h4>{{$inspection->category->description}}</h4>
    <small>{{$inspection->equipment->equipment->equipment}}</small>
    {{--  EQUIPO  --}}
    <h3>Equipo</h3>
    <table>
        <tr>
            <td><strong>Fabricante del equipo: </strong></td>
            <td>{{$inspection->equipment->equipment->model->trademark->trademark}}</td>
            <td><strong>Año: </strong>{{$inspection->equipment->equipment->manufacture_date}}</td>
        </tr>
        <tr>
            <td><strong>Datos del equipo: </strong></td>
            <td><strong>Modelo: </strong>{{$inspection->equipment->equipment->model->trademark_model}}</td>
            <td><strong>Serie: </strong>{{$inspection->equipment->equipment->serial_number}}</td>
        </tr>
    </table>
    <h3>Digrama Esquemático</h3>
    <small>{{$inspection->equipment->equipment->equipment_diagram}}</small>
    {{--  EQUIPO INSPECCIÓN  --}}
    {{--  INSPECCIÓN  --}}
    @foreach($inspection->category->sections as $section)
        <h3>{{$section->ct_inspection_section}}</h3>
        @if(count($section->subSections))
            @foreach($section->subSections as $subSection)
                <h4>{{$subSection->ct_inspection_section}}</h4>
                @if(count($subSection->fields))
                    <table>
                        @foreach($subSection->fields as $field)
                            <tr style="border-color: red">
                                <td>
                                    <small>{{$field->ct_inspection_form}}</small>
                                </td>
                                <td><small>{{$field->result->inspection_form_value}}</small></td>
                                <td>
                                    <small style="color: gray">{{$field->result->inspection_form_comments}}</small>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            @endforeach
        @endif
    @endforeach
</body>

</html>
