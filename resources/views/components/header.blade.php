<style>
    .header {
        background: #ffffff;
        border-bottom: 3px solid #e94560;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        padding: 0 2rem;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        position: sticky;
        top: 0;
        z-index: 100;
    }

    /* ── Left: accent bar + title ── */
    .header-left {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .header-accent {
        width: 4px;
        height: 28px;
        border-radius: 999px;
        background: linear-gradient(180deg, #e94560, #0f3460);
        flex-shrink: 0;
    }

    .header-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1a1a2e;
        letter-spacing: -0.3px;
        margin: 0;
        white-space: nowrap;
    }

    .header-title span {
        color: #e94560;
    }

    /* ── Right: meta info ── */
    .header-right {
        display: flex;
        align-items: center;
        gap: 1.25rem;
    }

    .header-date {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.8rem;
        color: #6b7280;
        background: #f3f4f6;
        padding: 0.35rem 0.75rem;
        border-radius: 999px;
        border: 1px solid #e5e7eb;
        white-space: nowrap;
    }

    .header-date-icon {
        width: 14px;
        height: 14px;
        opacity: 0.5;
    }

    /* ── Optional: @yield('header-actions') slot ── */
    .header-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .header-actions a,
    .header-actions button {
        font-size: 0.8rem;
        padding: 0.35rem 0.9rem;
        border-radius: 6px;
        border: 1px solid #e5e7eb;
        background: transparent;
        color: #374151;
        text-decoration: none;
        cursor: pointer;
        transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease;
        font-family: inherit;
    }

    .header-actions a:hover,
    .header-actions button:hover {
        background: #1a1a2e;
        color: #ffffff;
        border-color: #1a1a2e;
    }

    .header-actions .btn-primary {
        background: #e94560;
        color: #ffffff;
        border-color: #e94560;
    }

    .header-actions .btn-primary:hover {
        background: #c73652;
        border-color: #c73652;
    }

    @media (max-width: 640px) {
        .header {
            padding: 0 1rem;
            gap: 0.5rem;
        }

        .header-date {
            display: none;
        }

        .header-title {
            font-size: 1rem;
        }
    }
</style>

<header class="header">

    {{-- Left: accent + page title --}}
    <div class="header-left">
        <div class="header-accent"></div>
        <h1 class="header-title">
            @yield('title', 'MJDC <span>Project</span>')
        </h1>
    </div>

    {{-- Right: actions slot + date --}}
    <div class="header-right">

        {{-- inject per-page buttons/links here --}}
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
            {{ now()->format('F d, Y') }}
        </div>

    </div>

</header>
