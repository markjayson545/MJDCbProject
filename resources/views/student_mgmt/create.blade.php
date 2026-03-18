@extends('layouts.app')

@section('title', 'Create Student — MJDC')

@section('page-title', 'Create Student')
@section('page-subtitle', 'Add a new student to the system')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');
* { font-family: 'Outfit', sans-serif; box-sizing: border-box; }

:root {
    --primary:   #1a1a2e;
    --accent:    #e94560;
    --accent-dk: #c83550;
    --blue:      #0f3460;
    --border:    #e2e8f0;
    --text:      #1e293b;
    --muted:     #64748b;
    --card:      #ffffff;
    --bg:        #f8fafd;
    --r:         12px;
    --r-sm:      8px;
    --shadow:    0 1px 3px rgba(0,0,0,0.06), 0 2px 8px rgba(0,0,0,0.04);
}

.form-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--r);
    box-shadow: var(--shadow);
    overflow: hidden;
    max-width: 760px;
}
.form-card-header {
    background: linear-gradient(135deg, var(--primary) 0%, var(--blue) 100%);
    padding: 1.5rem 2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}
.form-card-header-icon {
    width: 44px; height: 44px;
    border-radius: 10px;
    background: rgba(255,255,255,0.1);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.form-card-header h2 {
    font-size: 1.1rem;
    font-weight: 700;
    color: #fff;
    margin: 0 0 0.15rem;
}
.form-card-header p {
    font-size: 0.8rem;
    color: rgba(255,255,255,0.7);
    margin: 0;
}
.form-card-body {
    padding: 2rem;
    display: grid;
    gap: 1.25rem;
}
.form-row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
}
.form-card-footer {
    padding: 1.25rem 2rem;
    background: var(--bg);
    border-top: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 0.875rem;
}
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.6rem 1.4rem;
    border-radius: var(--r-sm);
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    border: none;
    text-decoration: none;
    transition: all 0.15s ease;
    font-family: 'Outfit', sans-serif;
}
.btn-primary {
    background: var(--accent);
    color: #fff;
}
.btn-primary:hover {
    background: var(--accent-dk);
    box-shadow: 0 4px 14px rgba(233,69,96,0.4);
    transform: translateY(-1px);
}
.btn-ghost {
    background: transparent;
    color: var(--muted);
    border: 1.5px solid var(--border);
}
.btn-ghost:hover {
    border-color: var(--accent);
    color: var(--accent);
}
</style>

@include('student_mgmt.components.alerts')

<form action="{{ route('studentMgmt.store') }}" method="POST">
    @csrf

    <div class="form-card">
        <div class="form-card-header">
            <div class="form-card-header-icon">
                <svg width="22" height="22" fill="none" stroke="#fff" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <div>
                <h2>Student Information</h2>
                <p>Fill in all required fields marked with an asterisk</p>
            </div>
        </div>

        <div class="form-card-body">
            <div class="form-row-2">
                @php $student = null; @endphp
                {{-- First & Last Name in a row --}}
            </div>

            @include('student_mgmt.components.form-fields')
        </div>

        <div class="form-card-footer">
            <button type="submit" class="btn btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Create Student
            </button>
            <a href="{{ route('studentMgmt.index') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </div>
</form>
@endsection
