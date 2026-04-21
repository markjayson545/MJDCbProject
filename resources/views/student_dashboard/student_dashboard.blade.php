@extends('layouts.app')

@section('title', 'Student Dashboard - System >_')

@section('breadcrumb')
    <span class="main-breadcrumb-current">Dashboard</span>
@endsection

@section('page-title', 'Student Dashboard')
@section('page-subtitle', 'Overview of your academic progress and enrolled courses.')

@section('content')
    <!-- Quick Actions -->
{{--    <div class="quick-actions">--}}
{{--        <a href="{{ route('password.update.page') }}" class="quick-action-btn">--}}
{{--            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                      d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>--}}
{{--            </svg>--}}
{{--            Update Password--}}
{{--        </a>--}}
{{--        <a href="{{ route('studentDashboard', $student->id) }}" class="quick-action-btn">--}}
{{--            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                      d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>--}}
{{--            </svg>--}}
{{--            Refresh--}}
{{--        </a>--}}
{{--    </div>--}}

    <!-- Stats Overview Grid -->
    <div class="stats-grid">
        <div class="info-card green">
            <p class="info-card-title">Enrolled Courses</p>
            <p class="info-card-value">{{ $student->courses->count() ?? 0 }}</p>
            <p class="info-card-description">Active course enrollments.</p>
        </div>

        <div class="info-card blue">
            <p class="info-card-title">Degree Program</p>
            <p class="info-card-value">{{ $student->degree->title ?? 'N/A' }}</p>
            <p class="info-card-description">Current academic track.</p>
        </div>

        <div class="info-card green">
            <p class="info-card-title">Account Status</p>
            <p class="info-card-value">ACTIVE</p>
            <p class="info-card-description">Account is in good standing.</p>
        </div>
    </div>

    <!-- Student Information Card -->
    <div class="detail-card">
        <h3 class="detail-card-title">Personal Information</h3>
        <div class="detail-card-content">
            <div class="info-row">
                <span class="info-key">First Name</span>
                <span class="info-val">{{ $student->fname }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Middle Name</span>
                <span class="info-val">{{ $student->mname ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Last Name</span>
                <span class="info-val">{{ $student->lname }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Contact Number</span>
                <span class="info-val">{{ $student->contactno ?? 'N/A' }}</span>
            </div>
            @if($student->description)
                <div class="info-row">
                    <span class="info-key">Description</span>
                    <span class="info-val">{{ $student->description }}</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Enrolled Courses Section -->
    @if($student->courses->count() > 0)
        <div class="data-table-wrapper">
            <h3 class="table-title">Enrolled Courses</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Course ID</th>
                        <th>Course Title</th>
                        <th>Enrollment Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($student->courses as $course)
                        <tr>
                            <td><strong>#{{ $course->id }}</strong></td>
                            <td>{{ $course->title }}</td>
                            <td>{{ $course->pivot->created_at->format('M d, Y') }}</td>
                            <td><span class="badge badge-success">ENROLLED</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <p class="empty-state-title">No Courses Enrolled</p>
            <p class="empty-state-description">You are not currently enrolled in any courses. Please contact your advisor to enroll.</p>
        </div>
    @endif

@endsection
