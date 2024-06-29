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
        body {
            text-align: center;
            justify-content: center;
            font-family: 'dejavu sans', sans-serif;
        }
        table {
            border-spacing: 0;
            border-collapse: collapse;
            width: 100%;
        }
        .inspection-table {
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
    </main>

</body>

</html>
