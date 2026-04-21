@extends('layouts.app')

@section('title', 'Subject Details — MJDC')

@section('page-title', 'Subject Details')
@section('page-subtitle', 'Detailed view of a subject record')

@section('content')
<div class="student-header p-6 mb-6">
    <div class="student-header-banner">
        <div class="student-avatar">SB</div>
        <div class="student-header-info">
            <h2>{{ $course['title'] }}</h2>
            <p>Subject Record — ID #{{ $course['id'] }}</p>
        </div>
    </div>
    <div class="student-header-meta">
        <div class="meta-item">
            <strong>Created</strong>
            {{ $course['created_at'] }}
        </div>
        <div class="meta-item">
            <strong>Last Updated</strong>
            {{ $course['updated_at'] }}
        </div>
    </div>
</div>

<div class="details-card mb-6">
    <div class="details-card-header">Subject Information</div>

    <div class="detail-row">
        <span class="detail-key">ID</span>
        <span class="detail-val">{{ $course['id'] }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-key">Title</span>
        <span class="detail-val">{{ $course['title'] }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-key">Created At</span>
        <span class="detail-val">{{ $course['created_at'] }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-key">Last Updated</span>
        <span class="detail-val">{{ $course['updated_at'] }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-key">Students (Pivot)</span>
        <span class="detail-val">
            @if(! empty($course['students']))
                <div class="mjdc-table-wrap">
                    <table class="mjdc-table">
                        <thead>
                        <tr>
                            <th>Student</th>
                            <th>Email</th>
                            <th>Assigned At</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($course['students'] as $student)
                            <tr>
                                <td>{{ $student['lname'] }}, {{ $student['fname'] }}</td>
                                <td>{{ $student['email'] }}</td>
                                <td>{{ $student['pivot']['created_at'] ?? '—' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                —
            @endif
        </span>
    </div>
</div>

<div class="actions-bar mb-6">
    <a href="{{ route('courses.edit', $course['id']) }}" class="btn btn-blue">
        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>
        Edit Record
    </a>
    <a href="{{ route('courses.index') }}" class="btn btn-ghost">← Back to List</a>
</div>

<div class="delete-zone p-6">
    <div class="delete-zone-text">
        <strong>Danger Zone</strong>
        Permanently remove this subject record. This action cannot be undone.
    </div>
    <form action="{{ route('courses.destroy', $course['id']) }}" method="POST"
          onsubmit="return confirm('Are you sure you want to delete this subject? This cannot be undone.')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            Delete Subject
        </button>
    </form>
</div>
@endsection

