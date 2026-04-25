@extends('layouts.app')

@section('title', 'Create Degree — MJDC')

@section('page-title', 'Create Degree')
@section('page-subtitle', 'Add a new degree to the system')

@section('content')
    @include('admin.components.alerts')

    <form action="{{ route('admin.degrees.store') }}" method="POST">
        @csrf

        <div class="form-card">
            <div class="form-card-header">
                <div class="form-card-header-icon">
                    <svg width="22" height="22" fill="none" stroke="#fff" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <div>
                    <h2>Degree Information</h2>
                    <p>Fill in all required fields marked with an asterisk</p>
                </div>
            </div>

            <div class="form-card-body">
                <div class="form-row-2">
                    @php $degree = null; @endphp
                    {{-- no paired fields for degree --}}
                </div>

                @include('admin.components.degree-form-fields')
            </div>

            <div class="form-card-footer">
                <button type="submit" class="btn btn-primary">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create Degree
                </button>
                <a href="{{ route('admin.degrees.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </div>
    </form>
@endsection
