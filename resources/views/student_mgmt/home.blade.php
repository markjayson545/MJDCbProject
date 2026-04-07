@extends('layouts.app')

@section('title', 'Dashboard — MJDC')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Overview of your system activity')

@section('content')
{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card accent">
        <div class="stat-icon">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </div>
        <p class="stat-label">Total Students</p>
        <p class="stat-value">247</p>
        <p class="stat-delta up">↑ 12% from last month</p>
    </div>

    <div class="stat-card blue">
        <div class="stat-icon">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="stat-label">Pass Rate</p>
        <p class="stat-value">87.5%</p>
        <p class="stat-delta up">↑ 3.2% from last term</p>
    </div>

    <div class="stat-card success">
        <div class="stat-icon">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
            </svg>
        </div>
        <p class="stat-label">Average Grade</p>
        <p class="stat-value">82.3</p>
        <p class="stat-delta up">↑ 1.8 points</p>
    </div>

    <div class="stat-card warning">
        <div class="stat-icon">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="stat-label">Pending Reviews</p>
        <p class="stat-value">23</p>
        <p class="stat-delta down">5 urgent</p>
    </div>
</div>

{{-- Recent Activity Table --}}
<h3 class="section-heading">
    Recent Activity
    <a href="{{ route('studentMgmt.index') }}">View all →</a>
</h3>

<div class="mjdc-table-wrap">
    <table class="mjdc-table">
        <thead>
            <tr>
                <th>Student</th>
                <th>Subject</th>
                <th>Grade</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Mark Jayson V. Dela Cruz</strong></td>
                <td>Web Development</td>
                <td><strong>90</strong></td>
                <td><span class="t-badge t-badge-success">Passed</span></td>
                <td>Mar 5, 2026</td>
            </tr>
            <tr>
                <td><strong>Alexia Cayabyab</strong></td>
                <td>Database Systems</td>
                <td><strong>85</strong></td>
                <td><span class="t-badge t-badge-success">Passed</span></td>
                <td>Mar 4, 2026</td>
            </tr>
            <tr>
                <td><strong>Adrian Cabic</strong></td>
                <td>Programming Logic</td>
                <td><strong>74</strong></td>
                <td><span class="t-badge t-badge-danger">Failed</span></td>
                <td>Mar 3, 2026</td>
            </tr>
            <tr>
                <td><strong>Maria Santos</strong></td>
                <td>Computer Networks</td>
                <td><strong>88</strong></td>
                <td><span class="t-badge t-badge-success">Passed</span></td>
                <td>Mar 2, 2026</td>
            </tr>
            <tr>
                <td><strong>John Reyes</strong></td>
                <td>Software Engineering</td>
                <td><strong>92</strong></td>
                <td><span class="t-badge t-badge-success">Passed</span></td>
                <td>Mar 1, 2026</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="notice">
    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <span><strong>Note:</strong> This is placeholder data. Connect to your database to display real student information.</span>
</div>
@endsection
