<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/orientation.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        @include('layouts.navbar')

        <main>
            @yield('content')
        </main>
    </div>
    <nav class="navbar fixed-bottom py-0 justify-content-center">
        <small class="text-muted">Powered by {{ config('app.name') }}</small>
    </nav>

    {{-- Menu Toggle Script --}}
    <script>
        document.querySelector("#menu-toggle").addEventListener("click", function (e) {
            e.preventDefault();

            document.querySelector("#wrapper").classList.toggle("toggled");
        });

    </script>
</body>
</html>
