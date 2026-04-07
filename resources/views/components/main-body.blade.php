<main class="main-wrapper">
    <div class="main-container">

        @hasSection('breadcrumb')
            <nav class="main-breadcrumb">
                @yield('breadcrumb')
            </nav>
        @endif

        @hasSection('page-title')
            <div class="main-page-header">
                <div class="main-page-header-left">
                    <h2 class="main-page-title">@yield('page-title')</h2>

                    @hasSection('page-subtitle')
                        <p class="main-page-subtitle">@yield('page-subtitle')</p>
                    @endif
                </div>

                @hasSection('page-actions')
                    <div class="main-page-actions">
                        @yield('page-actions')
                    </div>
                @endif
            </div>
            <hr class="main-divider">
        @endif

        @if(session('success'))
            <div class="main-alert success">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="main-alert error">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="main-card">
            @yield('content')
        </div>

        @hasSection('content-extra')
            <div class="content-extra-wrapper">
                @yield('content-extra')
            </div>
        @endif

    </div>
</main>
