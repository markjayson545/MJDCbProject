@extends('layouts.app')

@php($teacher = session('teacher'))

@section('title', 'Teacher Dashboard - System >_')

@section('breadcrumb')
    <span class="main-breadcrumb-current">Dashboard</span>
@endsection

@section('page-title', 'Teacher Dashboard')
@section('page-subtitle', 'Overview of your courses and student progress.')

@section('content')
    <!-- Stats Overview Grid -->
    <div class="stats-grid">
        <div class="info-card success">
            <p class="info-card-title">Courses Teaching</p>
            <p class="info-card-value">{{ $courseCount ?? 0 }}</p>
            <p class="info-card-description">Active course assignments.</p>
        </div>

        <div class="info-card info">
            <p class="info-card-title">Total Students</p>
            <p class="info-card-value">{{ $studentCount ?? 0 }}</p>
            <p class="info-card-description">Across all courses.</p>
        </div>

        <div class="info-card warning">
            <p class="info-card-title">Avg Class Size</p>
            <p class="info-card-value">{{ $avgClassSize ?? 0 }}</p>
            <p class="info-card-description">Students per course.</p>
        </div>
    </div>

    <!-- Teacher Information Card -->
    <div class="detail-card">
        <h3 class="detail-card-title">Professional Information</h3>
        <div class="detail-card-content">
            <div class="info-row">
                <span class="info-key">First Name</span>
                <span class="info-val">{{ $teacher->fname ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Middle Name</span>
                <span class="info-val">{{ $teacher->mname ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Last Name</span>
                <span class="info-val">{{ $teacher->lname ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Email</span>
                <span class="info-val">{{ $teacher->email ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-key">Contact Number</span>
                <span class="info-val">{{ $teacher->contactno ?? 'N/A' }}</span>
            </div>
            @if($teacher->department)
                <div class="info-row">
                    <span class="info-key">Department</span>
                    <span class="info-val">{{ $teacher->department }}</span>
                </div>
            @endif
            @if($teacher->description)
                <div class="info-row">
                    <span class="info-key">Bio</span>
                    <span class="info-val">{{ $teacher->description }}</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Teaching Courses Section -->
    @if(isset($courses) && $courses->count() > 0)
        <div class="data-table-wrapper">
            <h3 class="table-title">Courses Currently Teaching</h3>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Course ID</th>
                        <th>Course Title</th>
                        <th>Students Enrolled</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                        <tr>
                            <td><strong>#{{ $course->id }}</strong></td>
                            <td>{{ $course->title }}</td>
                            <td>{{ $course->students_count ?? $course->students()->count() }}</td>
                            <td><span class="badge badge-success">ACTIVE</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <p class="empty-state-title">No Courses Assigned</p>
            <p class="empty-state-description">You are not currently assigned to any courses. Please contact your administrator to assign courses.</p>
        </div>
    @endif

@endsection

