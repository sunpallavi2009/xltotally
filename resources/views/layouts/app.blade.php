<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->

        <!-- Scripts -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
        <!-- Argon -->
        <link rel="stylesheet" href="{{ asset('assets/css/nucleo-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/nucleo-svg.css') }}">
        <link id="pagestyle"  rel="stylesheet" href="{{ asset('assets/css/argon-dashboard.css') }}">

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.0.0/dist/cdn.min.js" defer></script>
    </head>
    <body>

        @guest
            @yield('content')
        @endguest

        @auth
           
                <div class="position-absolute w-100 min-height-300 top-0" style="background-image: url('{{ asset('assets/images/profile-layout-header.jpg') }}'); background-position-y: 50%;">
                    <span class="mask bg-primary opacity-6"></span>
                </div>
                @include('layouts.partials.sidenav')
                    <main class="main-content border-radius-lg">
                        @yield('content')
                    </main>
           
        @endauth

            <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
            <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
            <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
            <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
            <script>
                var win = navigator.platform.indexOf('Win') > -1;
                if (win && document.querySelector('#sidenav-scrollbar')) {
                    var options = {
                        damping: '0.5'
                    }
                    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
                }
            </script>
            <!-- Github buttons -->
            <script async defer src="https://buttons.github.io/buttons.js"></script>
            <script src="{{ asset('assets/js/argon-dashboard.js') }}"></script>

            @stack('javascript')

    </body>
</html>
