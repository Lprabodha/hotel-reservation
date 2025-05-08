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

    @vite([
        'resources/css/themify-icons.css',
        'resources/css/flaticon.css',
        'resources/css/bootstrap.min.css',
        'resources/css/jquery-ui.css',
        'resources/css/animate.css',
        'resources/css/nice-select.css',
        'resources/css/owl.carousel.css',
        'resources/css/owl.theme.css',
        'resources/css/slick.css',
        'resources/css/slick-theme.css',
        'resources/css/swiper.min.css',
        'resources/css/owl.transitions.css',
        'resources/css/jquery.fancybox.css',
        'resources/css/odometer-theme-default.css',
        'resources/css/style.css'
    ])

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body>
    <div id="app" class="page-wrapper">
        @include('layouts.header')

        <main class="py-4">
            @yield('content')
        </main>
        @include('layouts.footer')

        @vite([
            'resources/js/jquery.min.js',
            'resources/js/bootstrap.bundle.min.js',
            'resources/js/modernizr.custom.js',
            'resources/js/jquery.dlmenu.js',
            'resources/js/jquery-plugin-collection.js',
            'resources/js/script.js'
        ])
    </div>
</body>

</html>
