@extends('layouts.app')

@section('title', 'Greetings')

@section('page-title', isset($client['name']) ? $client['name'] : 'Greetings')
@section('page-subtitle', 'Welcome message and details')

@section('content')
    @if (isset($client))
        <h3 class="section-heading">Client Information</h3>

        <div class="info-grid">
            <div class="info-card">
                <p class="info-card-title">Name</p>
                <p class="info-card-value">{{ $client['name'] }}</p>
            </div>
            <div class="info-card blue">
                <p class="info-card-title">Address</p>
                <p class="info-card-value">{{ $client['address'] }}</p>
            </div>
            <div class="info-card green">
                <p class="info-card-title">Grade</p>
                <p class="info-card-value">{{ $client['grade'] }}</p>
            </div>
            <div class="info-card yellow">
                <p class="info-card-title">Sex</p>
                <p class="info-card-value">{{ $client['sex'] }}</p>
            </div>
        </div>

        <div class="notice">
            @if ($client['grade'] >= 75 && $client['grade'] <= 100)
                <span>Your grade is passed.</span>
            @elseif ($client['grade'] >= 0 && $client['grade'] < 75)
                <span>Your grade is failing.</span>
            @else
                <span>Invalid grade value detected.</span>
            @endif
        </div>
    @else
        <p>No data available to display.</p>
    @endif

    <h3 class="section-heading">Star Pattern (For Loop)</h3>
    <div class="detail-card">
        <div class="code-block-output">
            @for($a=1; $a <= 5; $a++)
                @for($b = 1; $b <= $a; $b++)
                    *
                @endfor
                <br>
            @endfor
        </div>
    </div>

    <h3 class="section-heading">Number Sequence (While Loop)</h3>
    <div class="detail-card">
        <div class="flex flex-wrap gap-2">
            @php $z = 1; @endphp
            @while($z <= 10)
                <span class="badge badge-info">{{ $z }}</span>
                @php $z++; @endphp
            @endwhile
        </div>
    </div>

    <h3 class="section-heading">Students Data Table</h3>

    <div class="data-table-wrapper">
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
                            <strong>{{ $student['age'] }}</strong>
                            @unless ($student['age'] >= 18)
                                <span class="badge badge-danger">Minor</span>
                            @else
                                <span class="badge badge-success">Adult</span>
                            @endunless
                        </td>
                    </tr>
                    @if($loop->last)
                        <tr class="table-meta-row">
                            <td colspan="6">End of Student Data - {{ $loop->count }} Records</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="notice">
        @isset($students)
            <span>Students data is set and has {{ count($students) }} entries.</span>
        @else
            <span>Students variable is not set.</span>
        @endisset
    </div>

    <div class="notice">
        @if($grade % 2 == 0)
            <span><strong>{{ $grade }}</strong> has an even grade.</span>
        @else
            <span><strong>{{ $grade }}</strong> has an odd grade.</span>
        @endif
    </div>
@endsection
