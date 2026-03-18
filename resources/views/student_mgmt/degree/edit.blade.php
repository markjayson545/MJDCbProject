@extends('layouts.app')

@section('title', 'Edit Degree — MJDC')

@section('page-title', 'Edit Degree')
@section('page-subtitle', 'Update degree information')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');
* { font-family: 'Outfit', sans-serif; box-sizing: border-box; }

.form-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 2px 8px rgba(0,0,0,0.04);
    overflow: hidden;
    max-width: 760px;
}
.form-card-header {
    background: linear-gradient(135deg, #0f3460 0%, #1a3a6e 100%);
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
.form-card-header .student-name-badge {
    font-size: 0.75rem;
    background: rgba(255,255,255,0.15);
    color: #fff;
    padding: 0.2rem 0.7rem;
    border-radius: 999px;
    font-weight: 600;
    margin-top: 0.4rem;
    display: inline-block;
}
.form-card-body {
    padding: 2rem;
    display: grid;
    gap: 1.25rem;
}
.form-card-footer {
    padding: 1.25rem 2rem;
    background: #f8fafd;
    border-top: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 0.875rem;
    flex-wrap: wrap;
}
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.6rem 1.4rem;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    border: none;
    text-decoration: none;
    transition: all 0.15s ease;
    font-family: 'Outfit', sans-serif;
}
.btn-primary {
    background: #0f3460;
    color: #fff;
}
.btn-primary:hover {
    background: #0d2d53;
    box-shadow: 0 4px 14px rgba(15,52,96,0.4);
    transform: translateY(-1px);
}
.btn-ghost {
    background: transparent;
    color: #64748b;
    border: 1.5px solid #e2e8f0;
}
.btn-ghost:hover {
    border-color: #e94560;
    color: #e94560;
}
.btn-danger-ghost {
    background: transparent;
    color: #dc2626;
    border: 1.5px solid #fca5a5;
    margin-left: auto;
}
.btn-danger-ghost:hover {
    background: #fef2f2;
    border-color: #dc2626;
}
</style>

@include('student_mgmt.components.alerts')

<form action="{{ route('degrees.update', $degree['id']) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-card">
        <div class="form-card-header">
            <div class="form-card-header-icon">
                <svg width="22" height="22" fill="none" stroke="#fff" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <h2>Edit Degree Record</h2>
                <p>Update the degree information below</p>
                <span class="student-name-badge">
                    ID #{{ $degree['id'] }} — {{ $degree['name'] }}
                </span>
            </div>
        </div>

        <div class="form-card-body">
            @include('student_mgmt.components.degree-form-fields')
        </div>

        <div class="form-card-footer">
            <button type="submit" class="btn btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                Save Changes
            </button>
            <a href="{{ route('degrees.index') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </div>
</form>
@endsection
