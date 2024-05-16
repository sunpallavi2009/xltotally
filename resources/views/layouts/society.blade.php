<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.0.0/dist/cdn.min.js" defer></script>
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.society-navigation')

            <!-- Page Heading -->
   
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                      @yield('header')
                    </div>
                </header>
          

            <!-- Page Content -->
            <main>
                @yield('content')
                
                {{-- @include('layouts.sidebar') --}}
            </main>
        </div>
        @stack('scripts')
    </body>
</html>