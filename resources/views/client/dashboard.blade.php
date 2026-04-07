@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Overview of your activity')

@section('content')
    <div class="stats-grid">
        <div class="stat-card accent">
            <p class="stat-card-title">Total Students</p>
            <p class="stat-card-value">247</p>
            <p class="stat-card-change up">+12% from last month</p>
        </div>

        <div class="stat-card blue">
            <p class="stat-card-title">Pass Rate</p>
            <p class="stat-card-value">87.5%</p>
            <p class="stat-card-change up">+3.2% from last term</p>
        </div>

        <div class="stat-card success">
            <p class="stat-card-title">Average Grade</p>
            <p class="stat-card-value">82.3</p>
            <p class="stat-card-change up">+1.8 points</p>
        </div>

        <div class="stat-card warning">
            <p class="stat-card-title">Pending Reviews</p>
            <p class="stat-card-value">23</p>
            <p class="stat-card-change down">5 urgent</p>
        </div>
    </div>

    <h3 class="section-heading">Recent Activity</h3>

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
        <span>This dashboard currently uses sample metrics. Connect database queries for real-time values.</span>
    </div>
@endsection
