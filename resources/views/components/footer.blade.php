{{-- footer.blade.php or inside your layout --}}

<style>
    .footer {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        color: #e0e0e0;
        padding: 2.5rem 1.5rem 1.5rem;
        margin-top: 3rem;
        border-top: 3px solid #e94560;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        bottom: 0;
        width: 100%;
    }

    .footer-container {
        max-width: 1100px;
        margin: 0 auto;
    }

    .footer-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        margin-bottom: 1.5rem;
    }

    .footer-brand h3 {
        font-size: 1.4rem;
        font-weight: 700;
        color: #ffffff;
        margin: 0 0 0.4rem;
        letter-spacing: 0.5px;
    }

    .footer-brand p {
        font-size: 0.85rem;
        color: #9ca3af;
        margin: 0;
    }

    .footer-links h4,
    .footer-extra h4 {
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #e94560;
        margin: 0 0 0.75rem;
    }

    .footer-links ul,
    .footer-extra ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }

    .footer-links ul li a,
    .footer-extra ul li a {
        color: #9ca3af;
        text-decoration: none;
        font-size: 0.875rem;
        transition: color 0.2s ease;
    }

    .footer-links ul li a:hover,
    .footer-extra ul li a:hover {
        color: #e94560;
    }

    /* Slot for custom per-page footer content */
    .footer-custom-section {
        padding-bottom: 1rem;
        margin-bottom: 1rem;
        border-bottom: 1px dashed rgba(255,255,255,0.08);
    }

    .footer-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .footer-bottom p {
        margin: 0;
        font-size: 0.8rem;
        color: #6b7280;
    }

    .footer-bottom span {
        font-size: 0.75rem;
        color: #4b5563;
    }

    @media (max-width: 640px) {
        .footer-top {
            flex-direction: column;
        }

        .footer-bottom {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<footer class="footer">
    <div class="footer-container">

        {{-- Top section --}}
        <div class="footer-top">
            <div class="footer-brand">
                <h3>MJDC App</h3>
                <p>A Laravel App for activity</p>
            </div>

            <div class="footer-links">
                <h4>Navigation</h4>
                <ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ url('/about') }}">About</a></li>
                </ul>
            </div>

            <div class="footer-extra">
                <h4>Support</h4>
                <ul>
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
        </div>

        {{-- @yield() slot for page-specific footer content --}}
        @hasSection('footer-content')
            <div class="footer-custom-section">
                @yield('footer-content')
            </div>
        @endif

        {{-- Bottom bar --}}
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} MJDC App. All rights reserved.</p>
        </div>

    </div>
</footer>
