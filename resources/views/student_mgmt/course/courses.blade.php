@extends('layouts.app')

@section('title', 'Subject Management — MJDC')

@section('page-title', 'Subject Management')
@section('page-subtitle', 'List of all subjects in the system')

@section('content')
    @include('student_mgmt.components.alerts')

    <div class="list-toolbar">
    <span class="list-count">
        <strong>{{ count($courses ?? []) }}</strong> subject{{ count($courses ?? []) !== 1 ? 's' : '' }} found
    </span>
        <a href="{{ route('courses.create') }}" class="btn btn-primary">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Add Subject
        </a>
    </div>

    <div class="mjdc-table-wrap">
        <table class="mjdc-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Subject Title</th>
                <th>Linked Students</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($courses ?? [] as $course)
                <tr>
                    <td>{{ $course['id'] }}</td>
                    <td>
                        <span class="student-name">{{ $course['title'] }}</span>
                    </td>
                    <td>{{ $course['students_count'] ?? 0 }}</td>
                    <td>{{ $course['created_at'] }}</td>
                    <td>{{ $course['updated_at'] }}</td>
                    <td class="actions-cell">
                        <a href="{{ route('courses.show', $course['id']) }}" class="link-btn link-view">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            View
                        </a>
                        <a href="{{ route('courses.edit', $course['id']) }}" class="link-btn link-edit">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('courses.destroy', $course['id']) }}" method="POST"
                              class="inline-form"
                              onsubmit="return confirm('Delete {{ $course['title'] }}? This cannot be undone.')">
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
                    <td colspan="6">
                        <div class="empty-state">
                            <svg width="52" height="52" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253"/>
                            </svg>
                            <p class="title">No subjects found</p>
                            <p>Start by adding subjects to the system.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($courses) && method_exists($courses, 'links') && $courses->hasPages())
        {{ $courses->links('student_mgmt.components.pagination') }}
    @endif
@endsection

