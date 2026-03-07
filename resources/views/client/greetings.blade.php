@extends('layouts.app')

@section('title', 'Greetings')

@section('page-title', isset($client['name']) ? $client['name'] : 'Greetings')
@section('page-subtitle', 'Welcome message and details')

@section('content')
    @if (isset($client))
        <h3 style="font-size: 1.1rem; font-weight: 600; color: #1a1a2e; margin: 0 0 1.25rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e94560;">Client Information</h3>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
            <div style="background: #f9fafb; padding: 1rem; border-radius: 6px; border-left: 3px solid #e94560;">
                <p style="font-size: 0.75rem; color: #6b7280; margin: 0 0 0.25rem; font-weight: 600; text-transform: uppercase;">Name</p>
                <p style="font-size: 0.95rem; color: #1a1a2e; margin: 0; font-weight: 600;">{{ $client['name'] }}</p>
            </div>
            <div style="background: #f9fafb; padding: 1rem; border-radius: 6px; border-left: 3px solid #0f3460;">
                <p style="font-size: 0.75rem; color: #6b7280; margin: 0 0 0.25rem; font-weight: 600; text-transform: uppercase;">Address</p>
                <p style="font-size: 0.95rem; color: #1a1a2e; margin: 0; font-weight: 600;">{{ $client['address'] }}</p>
            </div>
            <div style="background: #f9fafb; padding: 1rem; border-radius: 6px; border-left: 3px solid #22c55e;">
                <p style="font-size: 0.75rem; color: #6b7280; margin: 0 0 0.25rem; font-weight: 600; text-transform: uppercase;">Grade</p>
                <p style="font-size: 0.95rem; color: #1a1a2e; margin: 0; font-weight: 600;">{{ $client['grade'] }}</p>
            </div>
            <div style="background: #f9fafb; padding: 1rem; border-radius: 6px; border-left: 3px solid #f59e0b;">
                <p style="font-size: 0.75rem; color: #6b7280; margin: 0 0 0.25rem; font-weight: 600; text-transform: uppercase;">Sex</p>
                <p style="font-size: 0.95rem; color: #1a1a2e; margin: 0; font-weight: 600;">{{ $client['sex'] }}</p>
            </div>
        </div>

        <div style="background: {{ $client['grade'] >= 75 ? '#d1fae5' : '#fee2e2' }}; padding: 1rem; border-radius: 6px; margin-bottom: 2rem; border-left: 4px solid {{ $client['grade'] >= 75 ? '#22c55e' : '#e94560' }};">
            <p style="margin: 0; font-weight: 600; color: {{ $client['grade'] >= 75 ? '#065f46' : '#991b1b' }};">
                @if ($client['grade'] >= 75 && $client['grade'] <= 100)
                    ✓ Your Grade is passed
                @elseif ($client['grade'] >= 0 && $client['grade'] < 75)
                    ✗ Your Grade is failing
                @else
                    ⚠ Invalid grade value
                @endif
            </p>
        </div>
    @else
        <p>No data available to display.</p>
    @endif

    <div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; margin-bottom: 1.5rem;">
        <h4 style="font-size: 1rem; font-weight: 600; color: #1a1a2e; margin: 0 0 1rem; padding-bottom: 0.75rem; border-bottom: 2px solid #e94560;">Star Pattern (For Loop)</h4>
        <div style="font-family: 'Courier New', monospace; font-size: 1.1rem; line-height: 1.4; color: #0f3460; font-weight: 600; background: #ffffff; padding: 1rem; border-radius: 6px; border: 1px solid #e5e7eb;">
            @for($a=1; $a <= 5; $a++)
                @for($b = 1; $b <= $a; $b++)
                    *
                @endfor
                <br>
            @endfor
        </div>
    </div>

    <div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; margin-bottom: 1.5rem;">
        <h4 style="font-size: 1rem; font-weight: 600; color: #1a1a2e; margin: 0 0 1rem; padding-bottom: 0.75rem; border-bottom: 2px solid #e94560;">Number Sequence (While Loop)</h4>
        <div style="display: flex; flex-wrap: wrap; gap: 0.75rem; background: #ffffff; padding: 1rem; border-radius: 6px; border: 1px solid #e5e7eb;">
            @php $z = 1; @endphp
            @while($z <= 10)
                <div style="display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: linear-gradient(135deg, #e94560, #d13852); color: #ffffff; font-weight: 700; border-radius: 6px; box-shadow: 0 2px 4px rgba(233, 69, 96, 0.2);">{{ $z }}</div>
                @php $z++; @endphp
            @endwhile
        </div>
    </div>

    <h3 style="font-size: 1.1rem; font-weight: 600; color: #1a1a2e; margin: 2rem 0 1.25rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e94560;">Students Data Table</h3>

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
            letter-spacing: 1px;
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

        .data-table .table-meta-row {
            background: #f3f4f6;
            font-weight: 600;
            color: #1a1a2e;
        }

        .data-table .table-meta-row td {
            text-align: center;
            padding: 0.75rem;
            border-top: 2px solid #e5e7eb;
            border-bottom: 2px solid #e5e7eb;
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

        .data-table .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }
    </style>

    <table class="data-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Grade</th>
                <th>Sex</th>
                <th>Rating</th>
                <th>Age</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                @if($loop->first)
                    <tr class="table-meta-row">
                        <td colspan="6">Start of Student Data</td>
                    </tr>
                @endif
                <tr>
                    <td><strong>{{ $student['name'] }}</strong></td>
                    <td>{{ $student['address'] }}</td>
                    <td><strong>{{ $student['grade'] }}</strong></td>
                    <td>{{ $student['sex'] }}</td>
                    <td>
                        @if ($student['grade'] >= 75 && $student['grade'] <= 100)
                            <span class="badge badge-success">Passed</span>
                        @elseif ($student['grade'] >= 0 && $student['grade'] < 75)
                            <span class="badge badge-danger">Failed</span>
                        @else
                            <span class="badge badge-warning">Invalid</span>
                        @endif
                    </td>
                    <td>
                        <strong>{{$student['age']}}</strong>
                        @unless ($student['age'] >= 18)
                            <span class="badge badge-danger">Minor</span>
                        @else
                            <span class="badge badge-success">Adult</span>
                        @endunless
                    </td>
                </tr>
                @if($loop->last)
                    <tr class="table-meta-row">
                        <td colspan="6">End of Student Data &mdash; {{$loop->count}} Records</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 6px; padding: 1rem; margin: 1.5rem 0; border-left: 4px solid #3b82f6;">
        <p style="margin: 0; font-size: 0.875rem; color: #1e40af;">
            @isset($students)
                <strong>Info:</strong> Students data is set and has {{ count($students) }} entries.
            @else
                <strong>Warning:</strong> Students variable is not set.
            @endisset
        </p>
    </div>

    <div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 6px; padding: 1rem; margin: 1.5rem 0;">
        <p style="margin: 0; font-size: 0.875rem; color: #374151;">
            @if($grade % 2 == 0)
                <strong>{{ $grade }}</strong> has an <strong style="color: #22c55e;">even</strong> grade.
            @else
                <strong>{{ $grade }}</strong> has an <strong style="color: #e94560;">odd</strong> grade.
            @endif
        </p>
    </div>
@endsection
