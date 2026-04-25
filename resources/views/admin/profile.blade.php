@extends('layouts.app')

@section('title', 'Profile - MJDC')

@section('page-title', 'Profile')
@section('page-subtitle', 'Account summary and academic information')

@section('content')
    <div class="profile-layout">
        <div class="profile-sidebar">
            <div class="profile-avatar">MJ</div>
            <p class="profile-name">Mark Jayson V. Dela Cruz</p>
            <p class="profile-role">Pangasinan State University</p>
            <span class="profile-role-badge">Student</span>
            <div class="profile-actions">
                <a href="{{ route('profile.edit') }}" class="cyber-btn-primary">Edit Profile</a>
                <a href="{{ route('profile.edit') }}" class="cyber-btn-secondary">Security Settings</a>
            </div>
        </div>

        <div class="profile-main">
            <div class="info-card">
                <div class="info-card-header">Personal Information</div>
                <div class="info-row">
                    <span class="info-key">Full Name</span>
                    <span class="info-val">Mark Jayson V. Dela Cruz</span>
                </div>
                <div class="info-row">
                    <span class="info-key">Email</span>
                    <span class="info-val">markjayson.delacruz@student.psu.edu.ph</span>
                </div>
                <div class="info-row">
                    <span class="info-key">Address</span>
                    <span class="info-val">Basista, Pangasinan</span>
                </div>
                <div class="info-row">
                    <span class="info-key">Phone</span>
                    <span class="info-val">+63 912 345 6789</span>
                </div>
                <div class="info-row">
                    <span class="info-key">Student ID</span>
                    <span class="info-val">2024-00001</span>
                </div>
                <div class="info-row">
                    <span class="info-key">Program</span>
                    <span class="info-val">BS Information Technology</span>
                </div>
                <div class="info-row">
                    <span class="info-key">Year Level</span>
                    <span class="info-val">3rd Year</span>
                </div>
            </div>

            <div class="info-card">
                <div class="info-card-header">Academic Performance</div>
                <div class="acad-stats">
                    <div class="acad-stat">
                        <p class="acad-label">GPA</p>
                        <p class="acad-val">3.75</p>
                    </div>
                    <div class="acad-stat">
                        <p class="acad-label">Units Completed</p>
                        <p class="acad-val">96</p>
                    </div>
                    <div class="acad-stat">
                        <p class="acad-label">Current Load</p>
                        <p class="acad-val">21</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h3 class="section-heading">Enrolled Subjects (Current Semester)</h3>

    <div class="mjdc-table-wrap">
        <table class="mjdc-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Subject Name</th>
                    <th>Units</th>
                    <th>Schedule</th>
                    <th>Instructor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>IT 301</strong></td>
                    <td>Web Development</td>
                    <td>3</td>
                    <td>MWF 9:00-10:00 AM</td>
                    <td>Prof. Juan dela Cruz</td>
                </tr>
                <tr>
                    <td><strong>IT 302</strong></td>
                    <td>Database Systems</td>
                    <td>3</td>
                    <td>TTH 1:00-2:30 PM</td>
                    <td>Prof. Maria Santos</td>
                </tr>
                <tr>
                    <td><strong>IT 303</strong></td>
                    <td>Software Engineering</td>
                    <td>3</td>
                    <td>MWF 2:00-3:00 PM</td>
                    <td>Prof. Pedro Reyes</td>
                </tr>
                <tr>
                    <td><strong>IT 304</strong></td>
                    <td>Computer Networks</td>
                    <td>3</td>
                    <td>TTH 10:00-11:30 AM</td>
                    <td>Prof. Ana Garcia</td>
                </tr>
                <tr>
                    <td><strong>GE 009</strong></td>
                    <td>Ethics</td>
                    <td>3</td>
                    <td>F 3:00-6:00 PM</td>
                    <td>Prof. Luis Gonzales</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="notice">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>This profile page currently shows placeholder values and can be wired to authenticated user data later.</span>
    </div>
@endsection
