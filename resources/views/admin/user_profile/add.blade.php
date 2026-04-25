@extends('layouts.app')

@section('title', 'Create User Profile — MJDC')

@section('page-title', 'Create User Profile')
@section('page-subtitle', 'Add a login profile for student linking')

@section('content')
    @include('admin.components.alerts')

    <form action="{{ route('admin.user-profiles.store') }}" method="POST">
        @csrf

        <div class="form-card">
            <div class="form-card-header">
                <div>
                    <h2>User Profile Information</h2>
                </div>
            </div>

            <div class="form-card-body">
                <div class="ff-group">
                    <label for="username">Username <span class="req">*</span></label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}">
                    @error('username')
                    <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="ff-group">
                    <label for="password">Password <span class="req">*</span></label>
                    <input type="password" name="password" id="password">
                    @error('password')
                    <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="ff-group">
                    <label for="password_confirmation">Confirm Password <span class="req">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation">
                    @error('password_confirmation')
                    <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-card-footer">
                <button type="submit" class="btn btn-primary">Create User Profile</button>
                <a href="{{ route('admin.user-profiles.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </div>
    </form>
@endsection
