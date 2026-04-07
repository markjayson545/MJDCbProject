@extends('layouts.app')

@section('title', 'Edit Student — MJDC')

@section('page-title', 'Edit Student')
@section('page-subtitle', 'Update student information')

@section('content')
    @include('student_mgmt.components.alerts')

    <form action="{{ route('studentMgmt.update', $student['id']) }}" method="POST">
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
                    <h2>Edit Student Record</h2>
                    <p>Update the student's information below</p>
                    <span class="student-name-badge">
                    ID #{{ $student['id'] }} — {{ $student['fname'] }} {{ $student['lname'] }}
                </span>
                </div>
            </div>

            <div class="form-card-body">
                @include('student_mgmt.components.student-form-fields')
            </div>

            <div class="form-card-footer">
                <button type="submit" class="btn btn-primary">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Changes
                </button>
                <a href="{{ route('studentMgmt.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </div>
    </form>
@endsection
