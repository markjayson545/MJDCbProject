@extends('layouts.app')

@section('title', 'Profile')

@section('page-title', 'Profile')
@section('page-subtitle', 'Manage your account information')

@section('content')
    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem; margin-bottom: 2rem;">
        <div style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; text-align: center;">
            <div style="width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, #e94560, #d13852); margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 3rem; font-weight: 700; box-shadow: 0 4px 12px rgba(233, 69, 96, 0.3);">
                MJ
            </div>
            <h3 style="font-size: 1.25rem; font-weight: 700; color: #1a1a2e; margin: 0 0 0.25rem;">Mark Jayson V. Dela Cruz</h3>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 0 0 1.5rem;">Student</p>

            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <button style="width: 100%; padding: 0.65rem 1rem; background: #e94560; color: #ffffff; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 0.875rem;">Edit Profile</button>
                <button style="width: 100%; padding: 0.65rem 1rem; background: transparent; color: #374151; border: 1px solid #e5e7eb; border-radius: 6px; font-weight: 500; cursor: pointer; font-size: 0.875rem;">Change Password</button>
            </div>
        </div>

        <div>
            <h3 style="font-size: 1rem; font-weight: 600; color: #1a1a2e; margin: 0 0 1.25rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e94560;">Personal Information</h3>

            <div style="display: grid; gap: 1rem; margin-bottom: 2rem;">
                <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6;">
                    <span style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">Full Name:</span>
                    <span style="color: #1a1a2e; font-size: 0.875rem;">Mark Jayson V. Dela Cruz</span>
                </div>
                <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6;">
                    <span style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">Email:</span>
                    <span style="color: #1a1a2e; font-size: 0.875rem;">markjayson.delacruz@student.psu.edu.ph</span>
                </div>
                <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6;">
                    <span style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">Address:</span>
                    <span style="color: #1a1a2e; font-size: 0.875rem;">Basista, Pangasinan</span>
                </div>
                <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6;">
                    <span style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">Phone:</span>
                    <span style="color: #1a1a2e; font-size: 0.875rem;">+63 912 345 6789</span>
                </div>
                <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6;">
                    <span style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">Student ID:</span>
                    <span style="color: #1a1a2e; font-size: 0.875rem;">2024-00001</span>
                </div>
                <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6;">
                    <span style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">Program:</span>
                    <span style="color: #1a1a2e; font-size: 0.875rem;">Bachelor of Science in Information Technology</span>
                </div>
                <div style="display: grid; grid-template-columns: 150px 1fr; gap: 1rem; padding: 0.75rem 0;">
                    <span style="font-weight: 600; color: #6b7280; font-size: 0.875rem;">Year Level:</span>
                    <span style="color: #1a1a2e; font-size: 0.875rem;">3rd Year</span>
                </div>
            </div>

            <h3 style="font-size: 1rem; font-weight: 600; color: #1a1a2e; margin: 2rem 0 1.25rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e94560;">Academic Performance</h3>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;">
                <div style="background: #f9fafb; padding: 1rem; border-radius: 6px; border-left: 3px solid #22c55e;">
                    <p style="font-size: 0.75rem; color: #6b7280; margin: 0 0 0.25rem; font-weight: 600; text-transform: uppercase;">GPA</p>
                    <p style="font-size: 1.5rem; color: #1a1a2e; margin: 0; font-weight: 700;">3.75</p>
                </div>
                <div style="background: #f9fafb; padding: 1rem; border-radius: 6px; border-left: 3px solid #0f3460;">
                    <p style="font-size: 0.75rem; color: #6b7280; margin: 0 0 0.25rem; font-weight: 600; text-transform: uppercase;">Units Completed</p>
                    <p style="font-size: 1.5rem; color: #1a1a2e; margin: 0; font-weight: 700;">96</p>
                </div>
                <div style="background: #f9fafb; padding: 1rem; border-radius: 6px; border-left: 3px solid #e94560;">
                    <p style="font-size: 0.75rem; color: #6b7280; margin: 0 0 0.25rem; font-weight: 600; text-transform: uppercase;">Current Load</p>
                    <p style="font-size: 1.5rem; color: #1a1a2e; margin: 0; font-weight: 700;">21</p>
                </div>
            </div>
        </div>
    </div>

    <h3 style="font-size: 1rem; font-weight: 600; color: #1a1a2e; margin: 2rem 0 1.25rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e94560;">Enrolled Subjects (Current Semester)</h3>

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
    </style>

    <table class="data-table">
        <thead>
            <tr>
                <th>Subject Code</th>
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

    <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 6px; padding: 1rem; margin: 1.5rem 0; border-left: 4px solid #3b82f6;">
        <p style="margin: 0; font-size: 0.875rem; color: #1e40af;">
            <strong>Info:</strong> This is placeholder data. Connect your authentication system to display actual user information.
        </p>
    </div>
@endsection
