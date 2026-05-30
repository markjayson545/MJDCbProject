<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>



        <!-- Prevent Flash of Unstyled Content (FOUC) -->
        <script>
            (function () {
                const theme = localStorage.getItem('theme') || 'auto';
                const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (theme === 'dark' || (theme === 'auto' && systemPrefersDark)) {
                    document.documentElement.classList.add('dark');
                    document.documentElement.classList.remove('light');
                } else {
                    document.documentElement.classList.add('light');
                    document.documentElement.classList.remove('dark');
                }
            })();
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="programming-mode">
        <div class="welcome-wrapper">

            <div class="liquid-glass w-full sm:max-w-md mt-6 px-6 py-5 overflow-hidden">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
