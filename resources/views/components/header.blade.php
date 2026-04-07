<header class="header">
    <div class="header-left">
        <div class="header-accent"></div>
        <h1 class="header-title">
            @yield('title', 'System <span>>_</span>')
        </h1>
    </div>

    <div class="header-right">
        @hasSection('header-actions')
            <div class="header-actions">
                @yield('header-actions')
            </div>
        @endif

        <div class="header-date">
            <svg class="header-date-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            {{ now()->format('Y-m-d H:i') }}
        </div>
    </div>
</header>
