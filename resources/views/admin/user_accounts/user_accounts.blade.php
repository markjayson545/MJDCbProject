@extends('layouts.app')

@section('title', 'User Account Management — MJDC')

@section('page-title', 'User Account Management')
@section('page-subtitle', 'Manage admin, student, and teacher logins')

@section('content')
	@include('admin.components.alerts')

	<div class="list-toolbar">
	<span class="list-count">
		<strong>{{ count($userAccounts ?? []) }}</strong> account{{ count($userAccounts ?? []) !== 1 ? 's' : '' }} found
	</span>
		<a href="{{ route('admin.user-accounts.create') }}" class="btn btn-primary">
			<svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
			</svg>
			Add User Account
		</a>
	</div>

	<div class="mjdc-table-wrap">
		<table class="mjdc-table">
			<thead>
			<tr>
				<th>ID</th>
				<th>Username</th>
				<th>Email</th>
				<th>Role</th>
				<th>Status</th>
				<th>Linked Profile</th>
				<th>Created At</th>
				<th>Updated At</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			@forelse($userAccounts ?? [] as $userAccount)
				<tr>
					<td>{{ $userAccount['id'] }}</td>
					<td>{{ $userAccount['username'] }}</td>
					<td>{{ $userAccount['email'] }}</td>
					<td>{{ ucfirst($userAccount['role'] ?? '—') }}</td>
					<td>{{ ! empty($userAccount['is_active']) ? 'Active' : 'Inactive' }}</td>
					<td>
						@if(! empty($userAccount['student']))
							Student — {{ $userAccount['student']['lname'] }}, {{ $userAccount['student']['fname'] }}
						@elseif(! empty($userAccount['teacher']))
							Teacher — {{ $userAccount['teacher']['lname'] }}, {{ $userAccount['teacher']['fname'] }}
						@else
							—
						@endif
					</td>
					<td>{{ $userAccount['created_at'] }}</td>
					<td>{{ $userAccount['updated_at'] }}</td>
					<td class="actions-cell">
						<a href="{{ route('admin.user-accounts.show', $userAccount['id']) }}" class="link-btn link-view">
							<svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
							</svg>
							View
						</a>
						<a href="{{ route('admin.user-accounts.edit', $userAccount['id']) }}" class="link-btn link-edit">
							<svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
							</svg>
							Edit
						</a>
						<form action="{{ route('admin.user-accounts.destroy', $userAccount['id']) }}" method="POST"
							  class="inline-form"
							  onsubmit="return confirm('Delete {{ $userAccount['username'] }}? This cannot be undone.')">
							@csrf
							@method('DELETE')
							<button type="submit" class="link-btn link-del" {{ (! empty($userAccount['student']) || ! empty($userAccount['teacher'])) ? 'disabled' : '' }}>
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
					<td colspan="9">
						<div class="empty-state">
							<p class="title">No user accounts found</p>
							<p>Start by adding admin, student, or teacher accounts.</p>
						</div>
					</td>
				</tr>
			@endforelse
			</tbody>
		</table>
	</div>
@endsection

