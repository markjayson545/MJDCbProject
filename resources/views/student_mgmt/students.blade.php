@extends('layouts.app')

@section('title', 'Student Management — MJDC')

@section('page-title', 'Student Management')
@section('page-subtitle', 'List of all students enrolled in the system')

@section('content')
    {{-- Toolbar --}}
    <div class="list-toolbar">
    <span class="list-count">
        <strong>{{ count($students ?? []) }}</strong> student{{ count($students ?? []) !== 1 ? 's' : '' }} found
    </span>
        <a href="{{ route('studentMgmt.create') }}" class="btn btn-primary">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Add Student
        </a>
    </div>

    {{-- Table --}}
    <div class="mjdc-table-wrap">
        <table class="mjdc-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Linked Profile</th>
                <th>Contact No.</th>
                <th>Degree</th>
                <th>Subjects</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($students ?? [] as $student)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <span class="student-name">{{ $student['lname'] }}, {{ $student['fname'] }} {{ $student['mname'] }}</span>
                    </td>
                    <td>{{ $student['user_profile']['username'] ?? '—' }}</td>
                    <td>{{ $student['contactno'] }}</td>
                    <td>{{ $student['degree']['name'] ?? '—' }}</td>
                    <td>
                        @if(! empty($student['courses']))
                            @foreach($student['courses'] as $course)
                                <div>
                                    {{ $course['title'] }}
                                    @if(! empty($course['pivot']['created_at']))
                                        <small>({{ $course['pivot']['created_at'] }})</small>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            —
                        @endif
                    </td>
                    <td>{{ $student['description'] }}</td>
                    <td class="actions-cell">
                        <a href="{{ route('studentMgmt.show', $student['id']) }}" class="link-btn link-view">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>
                        <a href="{{ route('studentMgmt.edit', $student['id']) }}" class="link-btn link-edit">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <form action="{{ route('studentMgmt.destroy', $student['id']) }}" method="POST"
                            class="inline-form"
                              onsubmit="return confirm('Delete {{ $student['fname'] . ' ' . $student['mname'] . ' ' . $student['lname'] }}? This cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="link-btn link-del">
                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <svg width="52" height="52" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <p class="title">No students found</p>
                            <p>Start by adding students to the system.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination: uses our custom view -- no Laravel default markup leaks through --}}
    @if(isset($students) && method_exists($students, 'links') && $students->hasPages())
        {{ $students->links('student_mgmt.components.pagination') }}
    @endif

@endsection
