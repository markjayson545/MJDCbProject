<style>
    /* ── Page wrapper ── */
    .main-wrapper {
        min-height: calc(100vh - 64px - 52px - 80px); /* viewport minus header, nav, footer */
        background: #f5f6fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* ── Content container ── */
    .main-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 2rem;
    }

    /* ── Page heading area ── */
    .main-page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.75rem;
    }

    .main-page-header-left {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }

    .main-page-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
        letter-spacing: -0.3px;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .main-page-title::before {
        content: '';
        display: inline-block;
        width: 4px;
        height: 22px;
        border-radius: 999px;
        background: linear-gradient(180deg, #e94560, #0f3460);
        flex-shrink: 0;
    }

    .main-page-subtitle {
        font-size: 0.85rem;
        color: #6b7280;
        margin: 0 0 0 1rem; /* aligns under title text, past the accent bar */
    }

    /* ── Breadcrumb ── */
    .main-breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.78rem;
        color: #9ca3af;
        margin-bottom: 1.75rem;
        flex-wrap: wrap;
    }

    .main-breadcrumb a {
        color: #6b7280;
        text-decoration: none;
        transition: color 0.15s ease;
    }

    .main-breadcrumb a:hover {
        color: #e94560;
    }

    .main-breadcrumb-sep {
        color: #d1d5db;
        font-size: 0.7rem;
    }

    .main-breadcrumb-current {
        color: #e94560;
        font-weight: 500;
    }

    /* ── Page-level action buttons slot ── */
    .main-page-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .main-page-actions a,
    .main-page-actions button {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.82rem;
        font-weight: 500;
        padding: 0.45rem 1rem;
        border-radius: 6px;
        border: 1px solid #e5e7eb;
        background: #ffffff;
        color: #374151;
        text-decoration: none;
        cursor: pointer;
        transition: background 0.15s ease, color 0.15s ease, border-color 0.15s ease;
        font-family: inherit;
    }

    .main-page-actions a:hover,
    .main-page-actions button:hover {
        background: #1a1a2e;
        color: #ffffff;
        border-color: #1a1a2e;
    }

    .main-page-actions .btn-primary {
        background: #e94560;
        color: #ffffff;
        border-color: #e94560;
    }

    .main-page-actions .btn-primary:hover {
        background: #c73652;
        border-color: #c73652;
    }

    /* ── Divider ── */
    .main-divider {
        border: none;
        border-top: 1px solid #e5e7eb;
        margin: 1.5rem 0;
    }

    /* ── Content card (default content wrapper) ── */
    .main-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 1.75rem;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
    }

    /* ── Alert / flash messages ── */
    .main-alert {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.85rem 1.1rem;
        border-radius: 8px;
        font-size: 0.855rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid transparent;
    }

    .main-alert.success {
        background: #f0fdf4;
        border-color: #22c55e;
        color: #15803d;
    }

    .main-alert.error {
        background: #fff1f2;
        border-color: #e94560;
        color: #be123c;
    }

    .main-alert.info {
        background: #eff6ff;
        border-color: #3b82f6;
        color: #1d4ed8;
    }

    .main-alert.warning {
        background: #fffbeb;
        border-color: #f59e0b;
        color: #b45309;
    }

    /* ── Responsive ── */
    @media (max-width: 640px) {
        .main-container {
            padding: 1.25rem 1rem;
        }

        .main-page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .main-card {
            padding: 1.25rem;
        }
    }
</style>

<main class="main-wrapper">
    <div class="main-container">

        {{-- ① Breadcrumb --}}
        @hasSection('breadcrumb')
            <nav class="main-breadcrumb">
                @yield('breadcrumb')
            </nav>
        @endif

        {{-- ② Page header: title + subtitle + actions --}}
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

        {{-- ③ Flash / alert messages --}}
        @if(session('success'))
            <div class="main-alert success">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="main-alert error">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- ④ Main dynamic content --}}
        <div class="main-card">
            @yield('content')
        </div>

        {{-- ⑤ Optional extra section below the card --}}
        @hasSection('content-extra')
            <div style="margin-top: 1.5rem;">
                @yield('content-extra')
            </div>
        @endif

    </div>
</main>
