@extends('layouts.app')

@section('title', 'User Account Details — MJDC')

@section('page-title', 'User Account Details')
@section('page-subtitle', 'Detailed view of a user account record')

@section('content')
	<div class="student-header p-6 mb-6">
		<div class="student-header-banner">
			<div class="student-avatar">UA</div>
			<div class="student-header-info">
				<h2>{{ $userAccount['username'] }}</h2>
				<p>{{ ucfirst($userAccount['role'] ?? 'User') }} Account — ID #{{ $userAccount['id'] }}</p>
			</div>
		</div>
		<div class="student-header-meta">
			<div class="meta-item">
				<strong>Status</strong>
				{{ ! empty($userAccount['is_active']) ? 'Active' : 'Inactive' }}
			</div>
			<div class="meta-item">
				<strong>Created</strong>
				{{ $userAccount['created_at'] }}
			</div>
		</div>
	</div>

	<div class="details-card mb-6">
		<div class="details-card-header">Account Information</div>

		<div class="detail-row">
			<span class="detail-key">Username</span>
			<span class="detail-val">{{ $userAccount['username'] }}</span>
		</div>
		<div class="detail-row">
			<span class="detail-key">Email</span>
			<span class="detail-val">{{ $userAccount['email'] }}</span>
		</div>
		<div class="detail-row">
			<span class="detail-key">Role</span>
			<span class="detail-val">{{ ucfirst($userAccount['role'] ?? '—') }}</span>
		</div>
		<div class="detail-row">
			<span class="detail-key">Linked Profile</span>
			<span class="detail-val">
				@if(! empty($userAccount['student']))
					Student — {{ $userAccount['student']['lname'] }}, {{ $userAccount['student']['fname'] }}
				@elseif(! empty($userAccount['teacher']))
					Teacher — {{ $userAccount['teacher']['lname'] }}, {{ $userAccount['teacher']['fname'] }}
				@else
					—
				@endif
			</span>
		</div>
		<div class="detail-row">
			<span class="detail-key">Last Updated</span>
			<span class="detail-val">{{ $userAccount['updated_at'] }}</span>
		</div>
	</div>

	<div class="actions-bar mb-6">
		<a href="{{ route('admin.user-accounts.edit', $userAccount['id']) }}" class="btn btn-blue">
			<svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
			</svg>
			Edit Account
		</a>
		<a href="{{ route('admin.user-accounts.index') }}" class="btn btn-ghost">← Back to List</a>
	</div>

	<div class="delete-zone p-5">
		<div class="delete-zone-text">
			<strong>Danger Zone</strong>
			Permanently remove this user account. This action cannot be undone.
		</div>
		<form action="{{ route('admin.user-accounts.destroy', $userAccount['id']) }}" method="POST"
			  onsubmit="return confirm('Are you sure you want to delete this user account? This cannot be undone.')">
			@csrf
			@method('DELETE')
			<button type="submit" class="btn btn-danger" {{ (! empty($userAccount['student']) || ! empty($userAccount['teacher'])) ? 'disabled' : '' }}>
				<svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
				</svg>
				Delete Account
			</button>
		</form>
	</div>
@endsection

