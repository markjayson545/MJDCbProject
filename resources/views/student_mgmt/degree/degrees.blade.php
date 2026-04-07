@extends('layouts.app')

@section('title', 'Degree Management — MJDC')

@section('page-title', 'Degree Management')
@section('page-subtitle', 'List of all degrees in the system')

@section('content')
    {{-- Toolbar --}}
    <div class="list-toolbar">
    <span class="list-count">
        <strong>{{ count($degrees ?? []) }}</strong> degree{{ count($degrees ?? []) !== 1 ? 's' : '' }} found
    </span>
        <a href="{{ route('degrees.create') }}" class="btn btn-primary">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Add Degree
        </a>
    </div>

    {{-- Table --}}
    <div class="mjdc-table-wrap">
        <table class="mjdc-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Degree Name</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($degrees ?? [] as $degree)
                <tr>
                    <td>{{ $degree['id'] }}</td>
                    <td>
                        <span class="student-name">{{$degree['name']}}</span>
                    </td>
                    <td>
                        <span class="student-name">{{$degree['created_at']}}</span>
                    </td>
                    <td>
                        <span class="student-name">{{$degree['updated_at']}}</span>
                    </td>
                    <td class="actions-cell">
                        <a href="{{ route('degrees.show', $degree['id']) }}" class="link-btn link-view">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            View
                        </a>
                        <a href="{{ route('degrees.edit', $degree['id']) }}" class="link-btn link-edit">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('degrees.destroy', $degree['id']) }}" method="POST"
                            class="inline-form"
                              onsubmit="return confirm('Delete {{ $degree['name'] }}? This cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="link-btn link-del">
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
                    <td colspan="5">
                        <div class="empty-state">
                            <svg width="52" height="52" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <p class="title">No degree found</p>
                            <p>Start by adding degrees to the system.</p>
                        </div>
                    </td>
                </tr>

            @endforelse
            </tbody>
        </table>
    </div>
@endsection
