<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <title inertia>{{ config('app.name', 'QSR Solutions') }}</title>

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

    <!-- CSS del color picker (dependencia) -->
    <link rel="stylesheet" href="https://unpkg.com/tui-color-picker/dist/tui-color-picker.css" />

    <!-- CSS principal del image editor -->
    <link rel="stylesheet" href="https://unpkg.com/tui-image-editor/dist/tui-image-editor.css" />

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead

    <!-- Scripts de dependencias -->
    <script src="https://unpkg.com/fabric/dist/fabric.js"></script>
    <script src="https://unpkg.com/tui-code-snippet/dist/tui-code-snippet.js"></script>
    <script src="https://unpkg.com/tui-color-picker/dist/tui-color-picker.js"></script>

    <!-- Script principal del image editor -->
    <script src="https://unpkg.com/tui-image-editor/dist/tui-image-editor.js"></script>
</head>

<body class="font-sans antialiased">
    @inertia
</body>
</html>
