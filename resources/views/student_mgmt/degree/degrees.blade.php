@extends('layouts.app')

@section('title', 'Degree Management — MJDC')

@section('page-title', 'Degree Management')
@section('page-subtitle', 'List of all degrees in the system')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');
        * { font-family: 'Outfit', sans-serif; box-sizing: border-box; }

        /* Color and spacing literals (replacing CSS variables to satisfy the linter) */
        /* primary: #1a1a2e, accent: #e94560, accent-dk: #c83550, blue: #0f3460, border: #e2e8f0, text: #1e293b, muted: #64748b, card: #ffffff, bg: #f8fafd */

        /* Toolbar */
        .list-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }
        .list-count {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 500;
        }
        .list-count strong { color: #1a1a2e; }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.55rem 1.25rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .btn-primary { background: #e94560; color: #fff; }
        .btn-primary:hover { background: #c83550; box-shadow: 0 4px 14px rgba(233,69,96,0.35); transform: translateY(-1px); }

        /* Table */
        .mjdc-table-wrap {
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid #e2e8f0;
        }
        .mjdc-table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
        }
        .mjdc-table thead {
            background: linear-gradient(135deg, #e94560 0%, #c83550 100%);
        }
        .mjdc-table thead th {
            padding: 1rem 1.25rem;
            text-align: left;
            font-size: 0.72rem;
            font-weight: 700;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.65px;
            white-space: nowrap;
        }
        .mjdc-table thead th:first-child { width: 90px; text-align: center; }
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

        /* Ensure body cell text (name, age, etc.) is always readable and not overridden by other styles */
        .mjdc-table tbody td,
        .mjdc-table tbody td * {
            color: #1e293b !important;
        }

        .mjdc-table tbody td .student-name,
        .mjdc-table tbody td .student-name * {
            font-weight: 600;
            color: #1a1a2e !important;
        }

        .mjdc-table tbody td .student-name small {
            display: block;
            font-weight: 400;
            color: #64748b !important;
            font-size: 0.75rem;
            margin-top: 0.1rem;
        }

        .mjdc-table tbody td:first-child {
            text-align: center;
            font-weight: 700;
            color: #64748b;
            font-size: 0.8rem;
            width: 90px;
        }
        .student-name {
            font-weight: 600;
            color: #1a1a2e;
        }
        .student-name small {
            display: block;
            font-weight: 400;
            color: #64748b;
            font-size: 0.75rem;
            margin-top: 0.1rem;
        }
        .actions-cell { white-space: nowrap; }
        .link-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.78rem;
            font-weight: 600;
            padding: 0.3rem 0.7rem;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.12s ease;
            cursor: pointer;
            border: none;
        }
        .link-view  { color: #0f3460; background: rgba(15,52,96,0.07); }
        .link-view:hover  { background: rgba(15,52,96,0.14); }
        .link-edit  { color: #d97706; background: rgba(245,158,11,0.08); }
        .link-edit:hover  { background: rgba(245,158,11,0.15); }
        .link-del   { color: #dc2626; background: rgba(220,38,38,0.07); }
        .link-del:hover   { background: rgba(220,38,38,0.14); }

        /* Badges */
        .yr-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.2rem 0.7rem;
            border-radius: 999px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .yr-emerald { background: #d1fae5; color: #065f46; }
        .yr-amber   { background: #fef3c7; color: #92400e; }
        .yr-orange  { background: #ffedd5; color: #9a3412; }
        .yr-blue    { background: #dbeafe; color: #1e40af; }
        .yr-rose    { background: #ffe4e6; color: #9f1239; }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #64748b;
        }
        .empty-state svg { margin: 0 auto 1rem; color: #d1d5db; }
        .empty-state p { margin: 0; font-size: 0.9rem; }
        .empty-state p.title { font-weight: 700; color: #1a1a2e; font-size: 1rem; margin-bottom: 0.35rem; }
    </style>

    {{-- Toolbar --}}
    <div class="list-toolbar">
    <span class="list-count">
        <strong>{{ count($degrees ?? []) }}</strong> degree{{ count($degrees ?? []) !== 1 ? 's' : '' }} found
    </span>
        <a href="{{ route('degrees.create') }}" class="btn btn-primary">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Add Degree
        </a>
    </div>

    {{-- Table --}}
    <div class="mjdc-table-wrap">
        <table class="mjdc-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Degree Name</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($degrees ?? [] as $degree)
                <tr style="color: #1e293b !important;">
                    <td style="color: #1e293b !important;">{{ $degree['id'] }}</td>
                    <td>
                        <span class="student-name" style="color: #1a1a2e !important;">{{$degree['name']}}</span>
                    </td>
                    <td>
                        <span class="student-name" style="color: #1a1a2e !important;">{{$degree['created_at']}}</span>
                    </td>
                    <td>
                        <span class="student-name" style="color: #1a1a2e !important;">{{$degree['updated_at']}}</span>
                    </td>
                    <td class="actions-cell">
                        <a href="{{ route('degrees.show', $degree['id']) }}" class="link-btn link-view">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            View
                        </a>
                        <a href="{{ route('degrees.edit', $degree['id']) }}" class="link-btn link-edit">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('degrees.destroy', $degree['id']) }}" method="POST"
                              style="display:inline;"
                              onsubmit="return confirm('Delete {{ $degree['name'] }}? This cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="link-btn link-del">
                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <svg width="52" height="52" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <p class="title">No degree found</p>
                            <p>Start by adding degrees to the system.</p>
                        </div>
                    </td>
                </tr>

            @endforelse
            </tbody>
        </table>
    </div>
@endsection
