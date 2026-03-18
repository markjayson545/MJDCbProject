<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');

.mjdc-alert {
    display: flex;
    align-items: flex-start;
    gap: 0.9rem;
    padding: 1rem 1.25rem;
    border-radius: 10px;
    margin-bottom: 1.25rem;
    border-left: 4px solid transparent;
    font-size: 0.875rem;
    font-family: 'Outfit', sans-serif;
    line-height: 1.55;
    animation: alertSlideIn 0.2s ease;
}
@keyframes alertSlideIn {
    from { opacity: 0; transform: translateY(-6px); }
    to   { opacity: 1; transform: translateY(0); }
}
.mjdc-alert-icon {
    flex-shrink: 0;
    width: 20px;
    height: 20px;
    margin-top: 1px;
}
.mjdc-alert-content strong {
    display: block;
    font-weight: 700;
    font-size: 0.875rem;
    margin-bottom: 0.15rem;
}
.mjdc-alert-success {
    background: #f0fdf4;
    border-color: #22c55e;
    color: #14532d;
}
.mjdc-alert-success .mjdc-alert-icon { color: #16a34a; }
.mjdc-alert-error {
    background: #fef2f2;
    border-color: #ef4444;
    color: #7f1d1d;
}
.mjdc-alert-error .mjdc-alert-icon { color: #dc2626; }
.mjdc-alert ul {
    margin: 0.35rem 0 0 1.1rem;
    padding: 0;
    list-style: disc;
}
.mjdc-alert ul li { margin-bottom: 0.2rem; font-size: 0.85rem; }
</style>

@if(session('success') || isset($success))
    <div class="mjdc-alert mjdc-alert-success" role="alert">
        <svg class="mjdc-alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div class="mjdc-alert-content">
            <strong>Success!</strong>
            {{ session('success') ?? $success }}
        </div>
    </div>
@endif

@if($errors->any())
    <div class="mjdc-alert mjdc-alert-error" role="alert">
        <svg class="mjdc-alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div class="mjdc-alert-content">
            <strong>Please fix the following errors:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
