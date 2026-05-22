<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            color: #111827;
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            line-height: 1.4;
        }

        h1 {
            font-size: 18px;
            margin: 0 0 4px;
        }

        .meta {
            color: #4b5563;
            margin-bottom: 16px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #d1d5db;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #e5e7eb;
            color: #111827;
            font-weight: 700;
        }

        tbody tr:nth-child(even) td {
            background: #f9fafb;
        }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <div class="meta">Generated {{ $generatedAt->format('F d, Y h:i A') }}</div>

    <table>
        <thead>
            <tr>
                @foreach($headings as $heading)
                    <th>{{ $heading }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $row)
                <tr>
                    @foreach($row as $value)
                        <td>{{ $value }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ max(count($headings), 1) }}">No records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
