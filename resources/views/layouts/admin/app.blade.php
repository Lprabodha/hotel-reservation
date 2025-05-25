<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    @vite(['resources/css/admin/style.css', 'resources/css/admin/remixicon.css', 'resources/css/admin/lib/bootstrap.min.css', 'resources/css/admin/lib/apexcharts.css', 'resources/css/admin/lib/dataTables.min.css',  'resources/css/admin/lib/editor.atom-one-dark.min.css', 'resources/css/admin/lib/editor.quill.snow.css', 'resources/css/admin/lib/flatpickr.min.css', 'resources/css/admin/lib/full-calendar.css', 'resources/css/admin/lib/jquery-jvectormap-2.0.5.css', 'resources/css/admin/lib/magnific-popup.css', 'resources/css/admin/lib/slick.css', 'resources/css/admin/lib/prism.css', 'resources/css/admin/lib/file-upload.css', 'resources/css/admin/lib/audioplayer.css'])

    @vite(['resources/sass/admin/main.scss', 'resources/js/admin/app.js'])

</head>

<body>
    <div id="app">
        @include('layouts.admin.side-menu')
        <main class="py-4 dashboard-main">
            @include('layouts.admin.header')
            @yield('content')
            @include('layouts.admin.footer')
        </main>
    </div>

    @vite(['resources/js/admin/app.js', 'resources/js/admin/homeOneChart.js', 'resources/js/admin/lib/bootstrap.bundle.min.js', 'resources/js/admin/lib/dataTables.min.js', 'resources/js/admin/lib/iconify-icon.min.js', 'resources/js/admin/lib/jquery-ui.min.js', 'resources/js/admin/lib/jquery-jvectormap-2.0.5.min.js', 'resources/js/admin/lib/jquery-jvectormap-world-mill-en.js', 'resources/js/admin/lib/magnifc-popup.min.js', 'resources/js/admin/lib/slick.min.js', 'resources/js/admin/lib/prism.js', 'resources/js/admin/lib/file-upload.js', 'resources/js/admin/lib/audioplayer.js', 'resources/js/admin/homeOneChart.js'])

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jvectormap@2.0.5/jquery-jvectormap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

</body>

</html>
