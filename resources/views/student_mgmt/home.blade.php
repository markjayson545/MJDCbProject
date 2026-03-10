@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Overview of your activity')

@section('content')
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.25rem; margin-bottom: 2rem;">
        <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);">
            <div style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; background: rgba(233, 69, 96, 0.1); color: #e94560;">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <p style="font-size: 0.8rem; font-weight: 500; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 0.5rem;">Total Students</p>
            <p style="font-size: 1.75rem; font-weight: 700; color: #1a1a2e; margin: 0 0 0.25rem;">247</p>
            <p style="font-size: 0.75rem; color: #22c55e; font-weight: 600;">↑ 12% from last month</p>
        </div>

        <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);">
            <div style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; background: rgba(15, 52, 96, 0.1); color: #0f3460;">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p style="font-size: 0.8rem; font-weight: 500; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 0.5rem;">Pass Rate</p>
            <p style="font-size: 1.75rem; font-weight: 700; color: #1a1a2e; margin: 0 0 0.25rem;">87.5%</p>
            <p style="font-size: 0.75rem; color: #22c55e; font-weight: 600;">↑ 3.2% from last term</p>
        </div>

        <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);">
            <div style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; background: rgba(34, 197, 94, 0.1); color: #22c55e;">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <p style="font-size: 0.8rem; font-weight: 500; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 0.5rem;">Average Grade</p>
            <p style="font-size: 1.75rem; font-weight: 700; color: #1a1a2e; margin: 0 0 0.25rem;">82.3</p>
            <p style="font-size: 0.75rem; color: #22c55e; font-weight: 600;">↑ 1.8 points</p>
        </div>

        <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);">
            <div style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p style="font-size: 0.8rem; font-weight: 500; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 0.5rem;">Pending Reviews</p>
            <p style="font-size: 1.75rem; font-weight: 700; color: #1a1a2e; margin: 0 0 0.25rem;">23</p>
            <p style="font-size: 0.75rem; color: #e94560; font-weight: 600;">5 urgent</p>
        </div>
    </div>

    <h3 style="font-size: 1.1rem; font-weight: 600; color: #1a1a2e; margin: 0 0 1.25rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e94560;">Recent Activity</h3>

    <style>
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .data-table thead {
            background: linear-gradient(135deg, #e94560 0%, #d13852 100%);
        }

        .data-table thead th {
            padding: 0.95rem 1rem;
            text-align: left;
            font-size: 0.85rem;
            font-weight: 600;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #c73652;
        }

        .data-table tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: background 0.15s ease;
        }

        .data-table tbody tr:hover {
            background: #f9fafb;
        }

        .data-table tbody tr:last-child {
            border-bottom: none;
        }

        .data-table tbody td {
            padding: 0.85rem 1rem;
            font-size: 0.875rem;
            color: #374151;
        }

        .data-table tbody td strong {
            color: #1a1a2e;
            font-weight: 600;
        }

        .data-table .badge {
            display: inline-block;
            padding: 0.25rem 0.65rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .data-table .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .data-table .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }
    </style>

    <table class="data-table">
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
                <td><span class="badge badge-success">Passed</span></td>
                <td>Mar 5, 2026</td>
            </tr>
            <tr>
                <td><strong>Alexia Cayabyab</strong></td>
                <td>Database Systems</td>
                <td><strong>85</strong></td>
                <td><span class="badge badge-success">Passed</span></td>
                <td>Mar 4, 2026</td>
            </tr>
            <tr>
                <td><strong>Adrian Cabic</strong></td>
                <td>Programming Logic</td>
                <td><strong>74</strong></td>
                <td><span class="badge badge-danger">Failed</span></td>
                <td>Mar 3, 2026</td>
            </tr>
            <tr>
                <td><strong>Maria Santos</strong></td>
                <td>Computer Networks</td>
                <td><strong>88</strong></td>
                <td><span class="badge badge-success">Passed</span></td>
                <td>Mar 2, 2026</td>
            </tr>
            <tr>
                <td><strong>John Reyes</strong></td>
                <td>Software Engineering</td>
                <td><strong>92</strong></td>
                <td><span class="badge badge-success">Passed</span></td>
                <td>Mar 1, 2026</td>
            </tr>
        </tbody>
    </table>

    <div style="background: #fffbeb; border: 1px solid #fef3c7; border-radius: 6px; padding: 1rem; margin: 1.5rem 0; border-left: 4px solid #f59e0b;">
        <p style="margin: 0; font-size: 0.875rem; color: #92400e;">
            <strong>Note:</strong> This is placeholder data. Connect to your database to display real student information.
        </p>
    </div>
@endsection
