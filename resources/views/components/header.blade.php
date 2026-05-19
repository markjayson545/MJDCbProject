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
