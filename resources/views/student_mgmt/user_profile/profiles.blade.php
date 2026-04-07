@extends('layouts.app')

@section('title', 'User Profile Management — MJDC')

@section('page-title', 'User Profile Management')
@section('page-subtitle', 'Manage student login profiles')

@section('content')
    @include('student_mgmt.components.alerts')

    <div class="list-toolbar">
    <span class="list-count">
        <strong>{{ count($profiles ?? []) }}</strong> profile{{ count($profiles ?? []) !== 1 ? 's' : '' }} found
    </span>
        <a href="{{ route('user-profiles.create') }}" class="btn btn-primary">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Add User Profile
        </a>
    </div>

    <div class="mjdc-table-wrap">
        <table class="mjdc-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Linked Student</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($profiles ?? [] as $profile)
                <tr>
                    <td>{{ $profile['id'] }}</td>
                    <td>{{ $profile['username'] }}</td>
                    <td>
                        @if(! empty($profile['student']))
                            {{ $profile['student']['lname'] }}, {{ $profile['student']['fname'] }}
                        @else
                            —
                        @endif
                    </td>
                    <td>{{ $profile['created_at'] }}</td>
                    <td>{{ $profile['updated_at'] }}</td>
                    <td class="actions-cell">
                        <a href="{{ route('user-profiles.edit', $profile['id']) }}" class="link-btn link-edit">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('user-profiles.destroy', $profile['id']) }}" method="POST" class="inline-form" onsubmit="return confirm('Delete {{ $profile['username'] }}? This cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="link-btn link-del" {{ ! empty($profile['student']) ? 'disabled' : '' }}>
                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <p class="title">No user profiles found</p>
                            <p>Start by adding user profiles to connect with students.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($profiles) && method_exists($profiles, 'links') && $profiles->hasPages())
        {{ $profiles->links('student_mgmt.components.pagination') }}
    @endif
@endsection

