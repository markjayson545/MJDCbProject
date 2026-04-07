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
