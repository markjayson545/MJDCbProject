<nav class="nav">
    <div class="nav-container">
        <ul class="nav-list">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    home
                </a>
            </li>

            <li>
                <a href="{{ route('admin.user-profiles.index') }}"
                   class="nav-link {{ request()->routeIs('admin.user-profiles.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5.121 17.804A9.967 9.967 0 0112 15c2.45 0 4.695.88 6.379 2.34M15 10a3 3 0 11-6 0 3 3 0 016 0m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    user_profiles
                </a>
            </li>

            <li>
                <a href="{{ route('admin.students.index') }}"
                   class="nav-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    students
                </a>
            </li>

            <li>
                <a href="{{ route('admin.degrees.index') }}"
                   class="nav-link {{ request()->routeIs('admin.degrees.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 14l9-5-9-5-9 5 9 5zM12 14l6.16-3.422a12.083 12.083 0 01.665-.33m0 0a12.083 12.083 0 0111.495 0m-11.495 0v5.658A12.094 12.094 0 013.515 21m0-5.658a12.093 12.093 0 01-.665-.33m0 0a12.083 12.083 0 00-11.495 0m11.495 0v5.658A12.094 12.094 0 0012 21c2.305 0 4.517-.72 6.485-2.034"/>
                    </svg>
                    degrees
                </a>
            </li>

            <li>
                <a href="{{ route('admin.courses.index') }}"
                   class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253"/>
                    </svg>
                    subjects
                </a>
            </li>

            <li>
                <a href="{{ route('admin.about') }}"
                   class="nav-link {{ request()->routeIs('admin.about') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    about_us
                </a>
            </li>

            <li>
                <a href="{{ route('admin.settings') }}"
                   class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    settings
                </a>
            </li>

        </ul>
    </div>
</nav>
