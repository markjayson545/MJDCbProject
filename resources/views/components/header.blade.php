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

        <!-- Client-based Theme Toggle Dropdown -->
        <div x-data="{
            open: false,
            theme: localStorage.getItem('theme') || 'auto',
            setTheme(val) {
                this.theme = val;
                this.open = false;
                applyTheme(val);
            }
        }" @theme-updated.window="theme = $event.detail" class="relative">
            <button @click="open = !open" class="btn btn-ghost flex flex-row items-center gap-1.5" style="padding: 0.42rem 0.75rem; min-width: 100px; justify-content: space-between;">
                <div class="flex flex-row items-center gap-1.5">
                    <!-- Sun Icon (Light) -->
                    <svg x-show="theme === 'light'" class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14 12a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <!-- Moon Icon (Dark) -->
                    <svg x-show="theme === 'dark'" class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                    <!-- System Monitor Icon (Auto) -->
                    <svg x-show="theme === 'auto'" class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span x-text="theme === 'auto' ? 'system' : theme" class="capitalize font-mono" style="font-size: 0.72rem;"></span>
                </div>
                <svg class="w-3 h-3 text-text-muted transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 12px; height: 12px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open" @click.outside="open = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-36 rounded-md shadow-lg py-1 z-50 glass-panel"
                 style="display: none; background: var(--clr-surface); border: var(--glass-border); text-align: left;">
                
                <button @click="setTheme('light')" class="flex w-full items-center gap-2 px-3 py-2 text-xs font-mono text-left hover:bg-glass-soft" style="color: var(--clr-text); background: transparent; border: none; cursor: pointer; justify-content: flex-start;">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 15px; height: 15px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14 12a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Light
                </button>
                
                <button @click="setTheme('dark')" class="flex w-full items-center gap-2 px-3 py-2 text-xs font-mono text-left hover:bg-glass-soft" style="color: var(--clr-text); background: transparent; border: none; cursor: pointer; justify-content: flex-start;">
                    <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 15px; height: 15px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                    Dark
                </button>
                
                <button @click="setTheme('auto')" class="flex w-full items-center gap-2 px-3 py-2 text-xs font-mono text-left hover:bg-glass-soft" style="color: var(--clr-text); background: transparent; border: none; cursor: pointer; justify-content: flex-start;">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 15px; height: 15px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    System
                </button>
            </div>
        </div>

        <div class="header-date">
            <svg class="header-date-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            {{ now()->format('Y-m-d H:i') }}
        </div>

        {{--        Logout Button--}}

        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: flex; padding: 10px; justify-content: center; align-items: center;">
            @csrf
            <button class="btn btn-ghost flex flex-row items-center" id="logout-button" type="button" style="color: red;">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Logout
            </button>
        </form>



    </div>
</header>

<div id="logout-modal" class="ajax-modal" style="display:none;">
    <div class="ajax-modal-overlay js-close-logout-modal"></div>
    <div class="ajax-modal-card" style="max-width:420px;">
        <div class="ajax-modal-header">
            <h3>Sign out</h3>
            <button type="button" class="btn btn-ghost js-close-logout-modal">Close</button>
        </div>
        <div class="form-card-body">
            <p>You are about to log out of the system.</p>
            <p class="ff-hint">You will need to log in again to continue.</p>
        </div>
        <div class="form-card-footer">
            <button type="button" class="btn btn-danger" id="logout-confirm">Logout</button>
            <button type="button" class="btn btn-ghost js-close-logout-modal">Cancel</button>
        </div>
    </div>
</div>
