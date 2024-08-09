<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Quality Service Renovables') }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' />
    <meta name="theme-color" content="#c40000" />
    <meta NAME="keywords" CONTENT="quality, service, renovables, eólico, energía" />
    <meta NAME="description" CONTENT="Servicios profesionales técnicos industriales, especializados en mecatrónica dentro de sector eólico y las nuevas fuentes de energías renovables" />
    <style>
        body {
            text-align: center;
            justify-content: center;
            font-family: Arial, sans-serif; /* Utilizamos una fuente legible */
            margin: 20px; /* Margen exterior */
        }
        table {
            border-spacing: 0;
            border-collapse: collapse;
            width: 100%;
        }

        .inspection-evidence table td {
            width: 50%;
            vertical-align: top;
            padding: 10px;
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
            margin-bottom: 10px; /* Espacio entre imágenes */
        }
        p {
            /*font-weight: bold;*/
            font-size: 14px;
            margin-bottom: 5px; /* Espacio inferior entre título y descripción */
        }
        span {
            font-size: 12px;
            color: #555;
            display: block; /* Asegura que el texto de descripción esté debajo del título */
        }

        .inspection-table thead th {
            border: 1px solid black;
        }

        .inspection-table tr td {
            border: 1px solid black;
        }

        /** Define the margins of your page **/
        @page {
            margin: 100px 25px;
        }

        .page-break {
            page-break-after: always;
        }

        header {
            position: fixed;
            top: -60px;
            left: 0;
            right: 0;
            margin-bottom: 10px;
            text-align: center;
            line-height: 35px;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            height: 50px;
            font-size: 10px;
            text-align: center;
            line-height: 15px;
        }
        .page-number:before {
            content: "Página " counter(page);
        }
        #title-header {
            color: grey;
        }
    </style>
</head>

<body class="font-sans antialiased">
@include('api.V1.Inspections.Reports.Layouts.header')
@include('api.V1.Inspections.Reports.Layouts.footer')
    <!-- Wrap the content of your PDF inside a main tag -->
    <main>
        {{--  PORTADA  --}}
        @include('api.V1.Inspections.Reports.Layouts.title')
        <div class="page-break"></div>
        {{--  EQUIPO  --}}
        @include('api.V1.Inspections.Reports.Layouts.equipment')
        <div class="page-break"></div>
        {{--  INSPECCIÓN  --}}
        @include('api.V1.Inspections.Reports.Layouts.inspection')
        <div class="page-break"></div>
        {{--  EVIDENCIAS  --}}
        @include('api.V1.Inspections.Reports.Layouts.evidences')
        {{--  CONCLUSIÓN  --}}
        <div class="page-break"></div>
        @include('api.V1.Inspections.Reports.Layouts.conclusion')
        {{--  APÉNDICE  --}}
        <div class="page-break"></div>
        @include('api.V1.Inspections.Reports.Layouts.indicators')
    </main>

</body>

</html>
