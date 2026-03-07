<style>
    .nav {
        background: #ffffff;
        border-bottom: 1px solid #e5e7eb;
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.05);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .nav-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .nav-list {
        display: flex;
        align-items: center;
        height: 52px;
        gap: 0.25rem;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .nav-link {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 1rem;
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 500;
        color: #4b5563;
        text-decoration: none;
        border-bottom: 2px solid transparent;
        transition: background 0.15s ease, color 0.15s ease, border-color 0.15s ease;
        white-space: nowrap;
    }

    .nav-link svg {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
        transition: stroke 0.15s ease;
    }

    /* Hover state */
    .nav-link:hover {
        background: #f3f4f6;
        color: #1a1a2e;
    }

    /* Active state — matches your red/navy theme */
    .nav-link.active {
        background: rgba(233, 69, 96, 0.07);
        color: #e94560;
        border-bottom: 2px solid #e94560;
        font-weight: 600;
    }

    .nav-link.active svg {
        stroke: #e94560;
    }

    /* Mobile: horizontal scroll instead of wrapping */
    @media (max-width: 640px) {
        .nav-container {
            padding: 0 1rem;
        }

        .nav-list {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        .nav-list::-webkit-scrollbar {
            display: none;
        }
    }
</style>

<nav class="nav">
    <div class="nav-container">
        <ul class="nav-list">

            <li>
                <a href="{{ route('greetings') }}"
                   class="nav-link {{ request()->routeIs('greetings') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    Greetings
                </a>
            </li>

            <li>
                <a href="{{ route('dashboard') }}"
                   class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('profile') }}"
                   class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profile
                </a>
            </li>

            <li>
                <a href="{{ route('about') }}"
                   class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    About Us
                </a>
            </li>

        </ul>
    </div>
</nav>
