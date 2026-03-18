@extends('layouts.app')

@section('title', 'Dashboard — MJDC')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Overview of your system activity')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');
* { font-family: 'Outfit', sans-serif; box-sizing: border-box; }

/* Color and spacing literals */
/* primary: #1a1a2e, accent: #e94560, accent-dk: #c83550, blue: #0f3460, border: #e2e8f0, text: #1e293b, muted: #64748b, card: #ffffff, bg: #f8fafd */

:root {
    --shadow-md: 0 4px 16px rgba(0,0,0,0.08);
}

/* Stats grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1.25rem;
    margin-bottom: 2rem;
}
.stat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    position: relative;
    overflow: hidden;
    transition: box-shadow 0.15s ease, transform 0.15s ease;
}
.stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
.stat-card::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
}
.stat-card.accent::after  { background: #e94560; }
.stat-card.blue::after    { background: #0f3460; }
.stat-card.success::after { background: #10b981; }
.stat-card.warning::after { background: #f59e0b; }

.stat-icon {
    width: 44px; height: 44px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 1rem;
}
.stat-label {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.65px;
    color: #64748b;
    margin: 0 0 0.4rem;
}
.stat-value {
    font-size: 2rem;
    font-weight: 800;
    color: #1a1a2e;
    margin: 0 0 0.3rem;
    letter-spacing: -0.03em;
    line-height: 1;
}
.stat-delta {
    font-size: 0.75rem;
    font-weight: 600;
}
.stat-delta.up   { color: #10b981; }
.stat-delta.down { color: #e94560; }

/* Section heading */
.section-heading {
    font-size: 1rem;
    font-weight: 700;
    color: #1a1a2e;
    padding-bottom: 0.6rem;
    border-bottom: 2px solid #e94560;
    margin: 0 0 1.25rem;
    letter-spacing: -0.01em;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.section-heading a {
    font-size: 0.78rem;
    font-weight: 600;
    color: #e94560;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
.section-heading a:hover { text-decoration: underline; }

/* Shared table */
.mjdc-table-wrap { overflow: hidden; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); }
.mjdc-table {
    width: 100%;
    border-collapse: collapse;
    background: #ffffff;
}
.mjdc-table thead {
    background: linear-gradient(135deg, #e94560 0%, #c83550 100%);
}
.mjdc-table thead th {
    padding: 0.95rem 1.25rem;
    text-align: left;
    font-size: 0.72rem;
    font-weight: 700;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 0.65px;
    white-space: nowrap;
}
.mjdc-table tbody tr {
    border-bottom: 1px solid #e2e8f0;
    transition: background 0.12s ease;
}
.mjdc-table tbody tr:last-child { border-bottom: none; }
.mjdc-table tbody tr:hover { background: #f8fafd; }
.mjdc-table tbody td {
    padding: 0.9rem 1.25rem;
    font-size: 0.875rem;
    color: #1e293b;
    vertical-align: middle;
}
.mjdc-table tbody td strong { color: #1a1a2e; font-weight: 600; }

/* Ensure table body text is readable */
.mjdc-table tbody td,
.mjdc-table tbody td * {
    color: #1e293b !important;
}

/* Badges */
.t-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.2rem 0.7rem;
    border-radius: 999px;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}
.t-badge-success { background: #d1fae5; color: #065f46; }
.t-badge-danger  { background: #fee2e2; color: #991b1b; }

/* Info note */
.notice {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    background: #fffbeb;
    border: 1px solid #fde68a;
    border-left: 4px solid #f59e0b;
    border-radius: 8px;
    padding: 0.9rem 1.1rem;
    margin-top: 1.25rem;
    font-size: 0.85rem;
    color: #92400e;
}
.notice svg { flex-shrink: 0; color: #f59e0b; margin-top: 1px; }
</style>

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card accent">
        <div class="stat-icon" style="background: rgba(233,69,96,0.1); color: var(--accent);">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </div>
        <p class="stat-label">Total Students</p>
        <p class="stat-value">247</p>
        <p class="stat-delta up">↑ 12% from last month</p>
    </div>

    <div class="stat-card blue">
        <div class="stat-icon" style="background: rgba(15,52,96,0.1); color: var(--blue);">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="stat-label">Pass Rate</p>
        <p class="stat-value">87.5%</p>
        <p class="stat-delta up">↑ 3.2% from last term</p>
    </div>

    <div class="stat-card success">
        <div class="stat-icon" style="background: rgba(16,185,129,0.1); color: #10b981;">
            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
            </svg>
        </div>
        <p class="stat-label">Average Grade</p>
        <p class="stat-value">82.3</p>
        <p class="stat-delta up">↑ 1.8 points</p>
    </div>

    <div class="stat-card warning">
        <div class="stat-icon" style="background: rgba(245,158,11,0.1); color: #f59e0b;">
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
