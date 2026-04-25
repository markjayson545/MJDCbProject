<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="programming-mode">
        @include('components.header')
        @if(request()->routeIs('admin.*'))
            @include('components.navigation')
        @endif

        @if(isset($slot))
            <main class="main-wrapper">
                <div class="main-container">
                    @if(isset($header))
                        <div class="main-page-header">
                            <div class="main-page-header-left">
                                <h2 class="main-page-title">{{ strip_tags($header) }}</h2>
                            </div>
                        </div>
                        <hr class="main-divider">
                    @endif

                    <div class="main-card">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        @else
            @include('components.main-body')
        @endif

        @include('components.footer')
    </body>
</html>
