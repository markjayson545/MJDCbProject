@extends('layouts.app')

@section('title', 'Student Details — MJDC')

@section('page-title', 'Student Details')
@section('page-subtitle', 'Detailed view of a student record')

@section('content')
{{-- Student header --}}
@php
    $initials = strtoupper(substr($student['fname'] ?? 'S', 0, 1) . substr($student['lname'] ?? '', 0, 1));
@endphp

<div class="student-header">
    <div class="student-header-banner">
        <div class="student-avatar">{{ $initials }}</div>
        <div class="student-header-info">
            <h2>{{ $student['fname'] }} {{ $student['mname'] ? $student['mname'].' ' : '' }}{{ $student['lname'] }}</h2>
            <p>Student Record — ID #{{ $student['id'] }}</p>
        </div>
    </div>
    <div class="student-header-meta">
        <div class="meta-item">
            <strong>Email</strong>
            {{ $student['email'] }}
        </div>
        <div class="meta-item">
            <strong>Contact</strong>
            {{ $student['contactno'] }}
        </div>
        <div class="meta-item">
            <strong>Created</strong>
            {{ $student['created_at'] }}
        </div>
    </div>
</div>

{{-- Details --}}
<div class="details-card">
    <div class="details-card-header">Student Information</div>

    <div class="detail-row">
        <span class="detail-key">First Name</span>
        <span class="detail-val">{{ $student['fname'] }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-key">Middle Name</span>
        <span class="detail-val">{{ $student['mname'] ?: '—' }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-key">Last Name</span>
        <span class="detail-val">{{ $student['lname'] }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-key">Contact Number</span>
        <span class="detail-val">{{ $student['contactno'] }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-key">Email Address</span>
        <span class="detail-val">{{ $student['email'] }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-key">Degree</span>
        <span class="detail-val">{{ $student['degree']['name'] ?? '—' }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-key">Description</span>
        <span class="detail-val description">{{ $student['description'] ?: 'No description provided.' }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-key">Created At</span>
        <span class="detail-val">{{ $student['created_at'] }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-key">Last Updated</span>
        <span class="detail-val">{{ $student['updated_at'] }}</span>
    </div>
</div>

{{-- Actions --}}
<div class="actions-bar">
    <a href="{{ route('studentMgmt.edit', $student['id']) }}" class="btn btn-blue">
        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>
        Edit Record
    </a>
    <a href="{{ route('studentMgmt.index') }}" class="btn btn-ghost">← Back to List</a>
</div>

{{-- Delete zone --}}
<div class="delete-zone">
    <div class="delete-zone-text">
        <strong>Danger Zone</strong>
        Permanently remove this student record. This action cannot be undone.
    </div>
    <form action="{{ route('studentMgmt.destroy', $student['id']) }}" method="POST"
          onsubmit="return confirm('Are you sure you want to delete this student? This cannot be undone.')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            Delete Student
        </button>
    </form>
</div>
@endsection
