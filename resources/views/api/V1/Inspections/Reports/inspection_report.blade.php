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
            /* arriba - derecha - abajo - izquierda */
            /*margin: 100px 25px 0px 25px;*/
            margin: 100px 25px 0px 25px;
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
            bottom: 60px;
            left: 25px;
            right: 25px;
            height: 30px;
            font-size: 10px;
            /*text-align: center;*/
            line-height: 15px;
        }
        .page-number:before {
            content: "Página " counter(page);
            font-size: 12px;
            vertical-align: top;
        }
        #title-header {
            color: #c10202;
            vertical-align: top;
            font-weight: bold;
            font-size: 15px;
        }
        ul {
            list-style-type: none;
            text-align: left; /* Asegurar que el texto está alineado a la izquierda */
        }
        .normal::before {
            content: "";
            display: inline-block;
            width: 10px;
            height: 10px;
            background-color: green;
            border-radius: 50%;
            margin-right: 4px;
        }
        .unusual::before {
            content: "";
            display: inline-block;
            width: 10px;
            height: 10px;
            background-color: yellow;
            border-radius: 50%;
            margin-right: 4px;
        }
        .repair::before {
            content: "";
            display: inline-block;
            width: 10px;
            height: 10px;
            background-color: red;
            border-radius: 50%;
            margin-right: 4px;
        }
        .comment {
            margin: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .comment .author {
            font-weight: bold;
            color: #444;
        }

        .comment p {
            margin-top: 10px;
            color: #333;
        }
        .badge {
            display: inline-block;
            padding: .25em .4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: left;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25rem;
            color: #444;
            background-color: #f9f9f9;
        }
        .image-badge img {
            width: 100%; /* Ajusta al tamaño que quieras. */
            max-width: 200px;
        }

        .image-badge .badge {
            display: block;  /* Esto coloca el badge en su propia línea, debajo de la imagen. */
            text-align: left; /* Centra el texto del badge. */
        }

        .primary-color{
            color: #c10202;
        }

        /* COVER */
        .cover{
            margin-top: 100px;
        }
        .cover td{
            vertical-align: top;
        }
       
        .space{
            margin-bottom: 75px;
        }

        .uppercase{
            text-transform: uppercase;
        }

        .italic{
            font-style: italic;
        }
        .justify{
            text-align: justify;
        }

        .border{
            border: 1px solid #000;
            padding: 3px;
        }

        .text-left{
            text-align: left;
        }

        .text-right{
            text-align: right;
        }   

        .text-center{
            text-align: center;
        }

        .v-top{
            vertical-align: top;
        }
        .m-0{
            margin: 0;
        }

        .v-center{
            vertical-align: middle;
        }

        .font-12{
            font-size: 12px;
        }

        .table-content p{
            margin-top: 5px;
        }

        .list{
            color: #000;
            text-decoration: none;
            font-size: 12px;
        }
        .sub-list{
            margin-left: 15px;
        }

        .section{
            font-size: 12px;
            margin-bottom: 75px;
        }

        .section p, .section a{
            font-size: 12px;
        }
        .w-50{
            width: 50%;
        }
        .bg-gray{
            background-color: lightgray;
        }
        .m-0{
            margin: 0;
        }
        .p-0{
            padding: 0;
        }
    </style>
</head>

<body class="font-sans antialiased">
@include('api.V1.Inspections.Reports.Layouts.header')
@include('api.V1.Inspections.Reports.Layouts.footer')
    <!-- Wrap the content of your PDF inside a main tag -->
    <main style="text-align: left">
        {{--  Ficha Técnica  --}}
        @include('api.V1.Inspections.Reports.Layouts.title')
        <div class="page-break"></div>
        {{--  Avisos  --}}
        @include('api.V1.Inspections.Reports.Layouts.advices')
        <div class="page-break"></div>
        {{--  Tabla de contenido  --}}
        @include('api.V1.Inspections.Reports.Layouts.table-content')
        {{--  Introducción  --}}
        @include('api.V1.Inspections.Reports.Layouts.introduction')
        {{--  Información  --}}
        @include('api.V1.Inspections.Reports.Layouts.information')
        <div class="page-break"></div>
        {{--  Escala de condición  --}}
        @include('api.V1.Inspections.Reports.Layouts.condition-scale')
        @include('api.V1.Inspections.Reports.Layouts.resume')
        <div class="page-break"></div>
        {{--  INSPECCIÓN  --}}
        @include('api.V1.Inspections.Reports.Layouts.inspection')
        <div class="page-break"></div>
        {{--  CONCLUSIÓN  --}}
        <div class="page-break"></div>
        @include('api.V1.Inspections.Reports.Layouts.conclusion')
        {{--  APÉNDICE  --}}
        <div class="page-break"></div>
        @include('api.V1.Inspections.Reports.Layouts.indicators')
    </main>

</body>

</html>
