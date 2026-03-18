@extends('layouts.app')

@section('title', 'Degree Details — MJDC')

@section('page-title', 'Degree Details')
@section('page-subtitle', 'Detailed view of a degree record')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');
* { font-family: 'Outfit', sans-serif; box-sizing: border-box; }

/* Color and spacing literals */
/* primary: #1a1a2e, accent: #e94560, accent-dk: #c83550, blue: #0f3460, border: #e2e8f0, text: #1e293b, muted: #64748b, card: #ffffff, bg: #f8fafd */

/* Header card */
.student-header {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 2px 8px rgba(0,0,0,0.04);
    overflow: hidden;
    margin-bottom: 1.5rem;
}
.student-header-banner {
    background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%);
    padding: 1.75rem 2rem;
    display: flex;
    align-items: center;
    gap: 1.25rem;
}
.student-avatar {
    width: 64px; height: 64px;
    border-radius: 50%;
    background: rgba(255,255,255,0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.5rem;
    font-weight: 800;
    flex-shrink: 0;
    border: 2px solid rgba(255,255,255,0.25);
    letter-spacing: -0.02em;
}
.student-header-info h2 {
    font-size: 1.4rem;
    font-weight: 800;
    color: #fff;
    margin: 0 0 0.25rem;
    letter-spacing: -0.02em;
}
.student-header-info p {
    font-size: 0.8rem;
    color: rgba(255,255,255,0.65);
    margin: 0;
}
.student-header-meta {
    padding: 1rem 2rem;
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
    background: #f8fafd;
    border-top: 1px solid #e2e8f0;
}
.meta-item { font-size: 0.8rem; color: #64748b; }
.meta-item strong { color: #1a1a2e; font-weight: 600; display: block; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 0.15rem; }

/* Details card */
.details-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 2px 8px rgba(0,0,0,0.04);
    overflow: hidden;
    margin-bottom: 1.5rem;
}
.details-card-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e2e8f0;
    background: #f8fafd;
    font-size: 0.85rem;
    font-weight: 700;
    color: #1a1a2e;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.details-card-header::before {
    content: '';
    width: 3px; height: 16px;
    background: #e94560;
    border-radius: 2px;
}
.detail-row {
    display: grid;
    grid-template-columns: 180px 1fr;
    gap: 1rem;
    padding: 0.9rem 1.5rem;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.875rem;
    align-items: start;
}
.detail-row:last-child { border-bottom: none; }
.detail-key { font-weight: 600; color: #64748b; font-size: 0.8rem; padding-top: 0.1rem; }
.detail-val { color: #1e293b; line-height: 1.55; word-break: break-word; }
.detail-val.description { color: #64748b; font-style: italic; }

/* Actions */
.actions-bar {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    flex-wrap: wrap;
}
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.6rem 1.4rem;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    border: none;
    text-decoration: none;
    transition: all 0.15s ease;
    font-family: 'Outfit', sans-serif;
}
.btn-blue { background: #0f3460; color: #fff; }
.btn-blue:hover { background: #0d2d53; box-shadow: 0 4px 14px rgba(15,52,96,0.35); transform: translateY(-1px); }
.btn-ghost { background: transparent; color: #64748b; border: 1.5px solid #e2e8f0; }
.btn-ghost:hover { border-color: #e94560; color: #e94560; }
.btn-danger { background: #dc2626; color: #fff; }
.btn-danger:hover { background: #b91c1c; box-shadow: 0 4px 14px rgba(220,38,38,0.35); transform: translateY(-1px); }

/* Confirm delete callout */
.delete-zone {
    background: #fef2f2;
    border: 1px solid #fca5a5;
    border-radius: 8px;
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}
.delete-zone-text { font-size: 0.85rem; color: #7f1d1d; }
.delete-zone-text strong { display: block; font-weight: 700; margin-bottom: 0.15rem; }
</style>

{{-- Header --}}
<div class="student-header">
    <div class="student-header-banner">
        <div class="student-avatar">DG</div>
        <div class="student-header-info">
            <h2>{{ $degree['name'] }}</h2>
            <p>Degree Record — ID #{{ $degree['id'] }}</p>
        </div>
    </div>
    <div class="student-header-meta">
        <div class="meta-item">
            <strong>Created</strong>
            {{ $degree['created_at'] }}
        </div>
        <div class="meta-item">
            <strong>Last Updated</strong>
            {{ $degree['updated_at'] }}
        </div>
    </div>
</div>

{{-- Details --}}
<div class="details-card">
    <div class="details-card-header">Degree Information</div>

    <div class="detail-row">
        <span class="detail-key">ID</span>
        <span class="detail-val">{{ $degree['id'] }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-key">Name</span>
        <span class="detail-val">{{ $degree['name'] }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-key">Created At</span>
        <span class="detail-val">{{ $degree['created_at'] }}</span>
    </div>
    <div class="detail-row">
        <span class="detail-key">Last Updated</span>
        <span class="detail-val">{{ $degree['updated_at'] }}</span>
    </div>
</div>

{{-- Actions --}}
<div class="actions-bar" style="margin-bottom: 1.5rem;">
    <a href="{{ route('degrees.edit', $degree['id']) }}" class="btn btn-blue">
        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>
        Edit Record
    </a>
    <a href="{{ route('degrees.index') }}" class="btn btn-ghost">← Back to List</a>
</div>

{{-- Delete zone --}}
<div class="delete-zone">
    <div class="delete-zone-text">
        <strong>Danger Zone</strong>
        Permanently remove this degree record. This action cannot be undone.
    </div>
    <form action="{{ route('degrees.destroy', $degree['id']) }}" method="POST"
          onsubmit="return confirm('Are you sure you want to delete this degree? This cannot be undone.')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            Delete Degree
        </button>
    </form>
</div>
@endsection
