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
