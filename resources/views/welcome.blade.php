<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MJDC System >_</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="programming-mode">
        <div class="welcome-wrapper">
            <div class="liquid-glass hero-card">
                <h1 class="hero-title">MJDC System >_</h1>
                <p class="hero-subtitle">Secure Access Terminal. Please identify yourself to proceed.</p>
                <div class="auth-links">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/admin/home') }}" class="cyber-btn-primary">Enter Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="cyber-btn-primary">Initialize Login</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="cyber-btn-secondary">Register Access</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </body>
</html>
