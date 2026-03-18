@extends('layouts.app')

@section('title', 'Profile — MJDC')

@section('page-title', 'Profile')
@section('page-subtitle', 'Manage your account information')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');
* { font-family: 'Outfit', sans-serif; box-sizing: border-box; }

:root {
    --primary:   #1a1a2e;
    --accent:    #e94560;
    --accent-dk: #c83550;
    --blue:      #0f3460;
    --border:    #e2e8f0;
    --text:      #1e293b;
    --muted:     #64748b;
    --card:      #ffffff;
    --bg:        #f8fafd;
    --r:         12px;
    --r-sm:      8px;
    --shadow:    0 1px 3px rgba(0,0,0,0.06), 0 2px 8px rgba(0,0,0,0.04);
    --shadow-md: 0 4px 16px rgba(0,0,0,0.08);
}

/* Layout */
.profile-layout {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
    align-items: start;
}
@media (max-width: 768px) {
    .profile-layout { grid-template-columns: 1fr; }
}

/* Sidebar */
.profile-sidebar {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--r);
    box-shadow: var(--shadow);
    padding: 2rem 1.5rem;
    text-align: center;
}
.profile-avatar {
    width: 110px; height: 110px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--accent), var(--accent-dk));
    margin: 0 auto 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 2.4rem;
    font-weight: 800;
    box-shadow: 0 6px 20px rgba(233,69,96,0.3);
    letter-spacing: -0.02em;
}
.profile-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--primary);
    margin: 0 0 0.25rem;
}
.profile-role {
    font-size: 0.8rem;
    color: var(--muted);
    margin: 0 0 1.5rem;
    font-weight: 500;
}
.profile-role-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.8rem;
    border-radius: 999px;
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    background: rgba(233,69,96,0.1);
    color: var(--accent);
    margin-bottom: 1.5rem;
}
.profile-actions {
    display: flex;
    flex-direction: column;
    gap: 0.65rem;
}
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.45rem;
    padding: 0.6rem 1.25rem;
    border-radius: var(--r-sm);
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    border: none;
    text-decoration: none;
    transition: all 0.15s ease;
    font-family: 'Outfit', sans-serif;
    width: 100%;
}
.btn-primary { background: var(--accent); color: #fff; }
.btn-primary:hover { background: var(--accent-dk); box-shadow: 0 4px 14px rgba(233,69,96,0.35); transform: translateY(-1px); }
.btn-ghost { background: transparent; color: var(--text); border: 1.5px solid var(--border); }
.btn-ghost:hover { border-color: var(--accent); color: var(--accent); }

/* Profile info */
.profile-main { display: flex; flex-direction: column; gap: 1.5rem; }
.info-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--r);
    box-shadow: var(--shadow);
    overflow: hidden;
}
.info-card-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border);
    background: var(--bg);
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--primary);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.info-card-header::before {
    content: '';
    width: 3px; height: 16px;
    background: var(--accent);
    border-radius: 2px;
}
.info-card-body { padding: 0; }
.info-row {
    display: grid;
    grid-template-columns: 160px 1fr;
    gap: 1rem;
    padding: 0.85rem 1.5rem;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.875rem;
    align-items: center;
}
.info-row:last-child { border-bottom: none; }
.info-key { font-weight: 600; color: var(--muted); font-size: 0.8rem; }
.info-val { color: var(--text); }

/* Academic stats */
.acad-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    padding: 1.25rem 1.5rem;
}
.acad-stat {
    background: var(--bg);
    padding: 1rem;
    border-radius: var(--r-sm);
    border-left: 3px solid var(--border);
}
.acad-stat.accent { border-left-color: var(--accent); }
.acad-stat.blue   { border-left-color: var(--blue); }
.acad-stat.green  { border-left-color: #10b981; }
.acad-stat .acad-label {
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.55px;
    color: var(--muted);
    margin: 0 0 0.3rem;
}
.acad-stat .acad-val {
    font-size: 1.6rem;
    font-weight: 800;
    color: var(--primary);
    margin: 0;
    letter-spacing: -0.02em;
}

/* Section heading */
.section-heading {
    font-size: 1rem;
    font-weight: 700;
    color: var(--primary);
    padding-bottom: 0.6rem;
    border-bottom: 2px solid var(--accent);
    margin: 0 0 1.25rem;
}

/* Table */
.mjdc-table-wrap { overflow: hidden; border-radius: var(--r); box-shadow: var(--shadow); }
.mjdc-table { width: 100%; border-collapse: collapse; background: var(--card); }
.mjdc-table thead { background: linear-gradient(135deg, var(--accent) 0%, var(--accent-dk) 100%); }
.mjdc-table thead th {
    padding: 0.95rem 1.25rem;
    text-align: left;
    font-size: 0.72rem;
    font-weight: 700;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 0.65px;
}
.mjdc-table tbody tr { border-bottom: 1px solid var(--border); transition: background 0.12s ease; }
.mjdc-table tbody tr:last-child { border-bottom: none; }
.mjdc-table tbody tr:hover { background: var(--bg); }
.mjdc-table tbody td { padding: 0.9rem 1.25rem; font-size: 0.875rem; color: var(--text); vertical-align: middle; }
.mjdc-table tbody td strong { color: var(--primary); font-weight: 600; }

/* Notice */
.notice {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-left: 4px solid #3b82f6;
    border-radius: var(--r-sm);
    padding: 0.9rem 1.1rem;
    margin-top: 1.25rem;
    font-size: 0.85rem;
    color: #1e40af;
}
.notice svg { flex-shrink: 0; color: #3b82f6; margin-top: 1px; }
</style>

{{-- Profile Layout --}}
<div class="profile-layout">
    {{-- Sidebar --}}
    <div class="profile-sidebar">
        <div class="profile-avatar">MJ</div>
        <p class="profile-name">Mark Jayson V. Dela Cruz</p>
        <p class="profile-role">Pangasinan State University</p>
        <span class="profile-role-badge">Student</span>
        <div class="profile-actions">
            <button class="btn btn-primary">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Profile
            </button>
            <button class="btn btn-ghost">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
                Change Password
            </button>
        </div>
    </div>

    {{-- Main --}}
    <div class="profile-main">
        {{-- Personal Info --}}
        <div class="info-card">
            <div class="info-card-header">Personal Information</div>
            <div class="info-card-body">
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
        </div>

        {{-- Academic Performance --}}
        <div class="info-card">
            <div class="info-card-header">Academic Performance</div>
            <div class="acad-stats">
                <div class="acad-stat green">
                    <p class="acad-label">GPA</p>
                    <p class="acad-val">3.75</p>
                </div>
                <div class="acad-stat blue">
                    <p class="acad-label">Units Completed</p>
                    <p class="acad-val">96</p>
                </div>
                <div class="acad-stat accent">
                    <p class="acad-label">Current Load</p>
                    <p class="acad-val">21</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Enrolled Subjects --}}
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
                <td>MWF 9:00–10:00 AM</td>
                <td>Prof. Juan dela Cruz</td>
            </tr>
            <tr>
                <td><strong>IT 302</strong></td>
                <td>Database Systems</td>
                <td>3</td>
                <td>TTH 1:00–2:30 PM</td>
                <td>Prof. Maria Santos</td>
            </tr>
            <tr>
                <td><strong>IT 303</strong></td>
                <td>Software Engineering</td>
                <td>3</td>
                <td>MWF 2:00–3:00 PM</td>
                <td>Prof. Pedro Reyes</td>
            </tr>
            <tr>
                <td><strong>IT 304</strong></td>
                <td>Computer Networks</td>
                <td>3</td>
                <td>TTH 10:00–11:30 AM</td>
                <td>Prof. Ana Garcia</td>
            </tr>
            <tr>
                <td><strong>GE 009</strong></td>
                <td>Ethics</td>
                <td>3</td>
                <td>F 3:00–6:00 PM</td>
                <td>Prof. Luis Gonzales</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="notice">
    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <span><strong>Info:</strong> This is placeholder data. Connect your authentication system to display actual user information.</span>
</div>
@endsection
