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

    <!-- Styles -->
    <link rel="stylesheet" href="/assets/css/admin/lib/remixicon.css">
    <link rel="stylesheet" href="/assets/css/admin/lib/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/admin/lib/apexcharts.css">
    <link rel="stylesheet" href="/assets/css/admin/lib/dataTables.min.css">
    <link rel="stylesheet" href="/assets/css/admin/lib/editor-katex.min.css">
    <link rel="stylesheet" href="/assets/css/admin/lib/editor.atom-one-dark.min.css">
    <link rel="stylesheet" href="/assets/css/admin/lib/editor.quill.snow.css">
    <link rel="stylesheet" href="/assets/css/admin/lib/flatpickr.min.css">
    <link rel="stylesheet" href="/assets/css/admin/lib/full-calendar.css">
    <link rel="stylesheet" href="/assets/css/admin/lib/jquery-jvectormap-2.0.5.css">
    <link rel="stylesheet" href="/assets/css/admin/lib/magnific-popup.css">
    <link rel="stylesheet" href="/assets/css/admin/lib/slick.css">
    <link rel="stylesheet" href="/assets/css/admin/lib/prism.css">
    <link rel="stylesheet" href="/assets/css/admin/lib/file-upload.css">
    <link rel="stylesheet" href="/assets/css/admin/lib/audioplayer.css">
    <link rel="stylesheet" href="/assets/css/admin/lib/style.css">

    @yield('style')

    @vite(['resources/sass/admin/main.scss'])

    {!! ToastMagic::styles() !!}
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

    <!-- Scripts -->
    <script src="/assets/js/admin/lib/jquery-3.7.1.min.js"></script>
    <script src="/assets/js/admin/lib/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/admin/lib/dataTables.min.js"></script>
    <script src="/assets/js/admin/lib/iconify-icon.min.js"></script>
    <script src="/assets/js/admin/lib/jquery-ui.min.js"></script>
    <script src="/assets/js/admin/lib/jquery-jvectormap-2.0.5.min.js"></script>
    <script src="/assets/js/admin/lib/jquery-jvectormap-world-mill-en.js"></script>
    <script src="/assets/js/admin/lib/magnifc-popup.min.js"></script>
    <script src="/assets/js/admin/full-calendar.js"></script>
    <script src="/assets/js/admin/lib/slick.min.js"></script>
    <script src="/assets/js/admin/lib/prism.js"></script>
    <script src="/assets/js/admin/lib/file-upload.js"></script>
    <script src="/assets/js/admin/lib/audioplayer.js"></script>

    @vite(['resources/js/admin/app.js'])
    @yield('scripts')

    {!! ToastMagic::scripts() !!}
</body>

</html>
