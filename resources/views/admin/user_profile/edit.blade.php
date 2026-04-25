@extends('layouts.app')

@section('title', 'Edit User Profile — MJDC')

@section('page-title', 'Edit User Profile')
@section('page-subtitle', 'Update student login profile details')

@section('content')
    @include('admin.components.alerts')

    <form action="{{ route('admin.user-profiles.update', $profile['id']) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-card">
            <div class="form-card-header">
                <div>
                    <h2>Edit User Profile</h2>
                    <p>ID #{{ $profile['id'] }}</p>
                </div>
            </div>

            <div class="form-card-body">
                <div class="ff-group">
                    <label for="username">Username <span class="req">*</span></label>
                    <input type="text" name="username" id="username"
                           value="{{ old('username', $profile['username']) }}">
                    @error('username')
                    <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="ff-group">
                    <label for="password">New Password</label>
                    <input type="password" name="password" id="password">
                    <span class="ff-hint">Leave blank to keep current password.</span>
                    @error('password')
                    <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="ff-group">
                    <label for="password_confirmation">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation">
                    @error('password_confirmation')
                    <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-card-footer">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('admin.user-profiles.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </div>
    </form>
@endsection
