@extends('layouts.app')

@section('title', 'Edit Subject — MJDC')

@section('page-title', 'Edit Subject')
@section('page-subtitle', 'Update subject information')

@section('content')
    @include('admin.components.alerts')

    <form action="{{ route('admin.courses.update', $course['id']) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-card">
            <div class="form-card-header">
                <div class="form-card-header-icon">
                    <svg width="22" height="22" fill="none" stroke="#fff" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h2>Edit Subject Record</h2>
                    <p>Update the subject information below</p>
                    <span class="student-name-badge">
                    ID #{{ $course['id'] }} — {{ $course['title'] }}
                </span>
                </div>
            </div>

            <div class="form-card-body">
                @include('admin.components.course-form-fields')

                @php
                    $selectedStudentIds = collect(old('student_ids', $course['students'] ?? []))
                        ->map(fn ($student) => is_array($student) ? (string) ($student['id'] ?? '') : (string) $student)
                        ->filter()
                        ->values()
                        ->all();

                    $currentlyEnrolledCount = (int) ($course['students_count'] ?? count($course['students'] ?? []));
                    $selectedEnrollmentCount = count($selectedStudentIds);
                    $totalStudentCount = count($students ?? []);
                    $notEnrolledCount = max($totalStudentCount - $selectedEnrollmentCount, 0);
                @endphp

                <div class="details-card">
                    <div class="details-card-header">Manage Enrolled Students</div>

                    <div class="card-grid">
                        <div class="stat-card success">
                            <p class="stat-card-title">Currently Enrolled</p>
                            <p class="stat-card-value">{{ $currentlyEnrolledCount }}</p>
                            <p class="stat-card-change">Saved enrollment records</p>
                        </div>

                        <div class="stat-card accent">
                            <p class="stat-card-title">Selected In Form</p>
                            <p class="stat-card-value">{{ $selectedEnrollmentCount }}</p>
                            <p class="stat-card-change">Will be applied after save</p>
                        </div>

                        <div class="stat-card warning">
                            <p class="stat-card-title">Total Students</p>
                            <p class="stat-card-value">{{ $totalStudentCount }}</p>
                            <p class="stat-card-change">Available for enrollment</p>
                        </div>

                        <div class="stat-card">
                            <p class="stat-card-title">Not Enrolled</p>
                            <p class="stat-card-value">{{ $notEnrolledCount }}</p>
                            <p class="stat-card-change">Students not selected in form</p>
                        </div>
                    </div>

                    @if(! empty($students))
                        <div class="ff-group">
                            <label for="student_ids">Enrolled Students</label>

                            <div id="student_ids" class="ff-checkbox-list">
                                @foreach($students as $student)
                                    <label for="student_ids_{{ $student['id'] }}" class="ff-checkbox-item">
                                        <input
                                                type="checkbox"
                                                name="student_ids[]"
                                                id="student_ids_{{ $student['id'] }}"
                                                value="{{ $student['id'] }}"
                                                {{ in_array((string) $student['id'], $selectedStudentIds, true) ? 'checked' : '' }}
                                        >
                                        <span>{{ $student['lname'] }}, {{ $student['fname'] }} — {{ $student['email'] }}</span>
                                    </label>
                                @endforeach
                            </div>

                            @error('student_ids')
                            <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
                            @enderror
                            @error('student_ids.*')
                            <span class="ff-hint" style="color:#ef4444;">{{ $message }}</span>
                            @enderror
                            <span class="ff-hint">Select the students to keep enrolled in this subject.</span>
                        </div>
                    @else
                        <div class="notice">
                            No students are available yet. Create student records first to manage subject enrollment.
                        </div>
                    @endif

                    @if(! empty($course['students']))
                        <div class="mjdc-table-wrap">
                            <table class="mjdc-table">
                                <thead>
                                <tr>
                                    <th>Currently Enrolled Student</th>
                                    <th>Email</th>
                                    <th>Assigned At</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($course['students'] as $enrolledStudent)
                                    <tr>
                                        <td>{{ $enrolledStudent['lname'] }}, {{ $enrolledStudent['fname'] }}</td>
                                        <td>{{ $enrolledStudent['email'] }}</td>
                                        <td>{{ $enrolledStudent['pivot']['created_at'] ?? '—' }}</td>
                                        <td>
                                            <a href="{{ route('admin.students.show', $enrolledStudent['id']) }}"
                                               class="link-btn link-view">View Student</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-card-footer">
                <button type="submit" class="btn btn-primary">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Changes
                </button>
                <a href="{{ route('admin.courses.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </div>
    </form>
@endsection
