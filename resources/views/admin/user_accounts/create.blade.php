@extends('layouts.app')

@section('title', 'Create User Account — MJDC')

@section('page-title', 'Create User Account')
@section('page-subtitle', 'Add a new admin, student, or teacher account')

@section('content')
	@include('admin.components.alerts')

	<form action="{{ route('admin.user-accounts.store') }}" method="POST">
		@csrf

		<div class="form-card">
			<div class="form-card-header">
				<div class="form-card-header-icon">
					<svg width="22" height="22" fill="none" stroke="#fff" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							  d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
					</svg>
				</div>
				<div>
					<h2>User Account Information</h2>
					<p>Fill in all required fields marked with an asterisk</p>
				</div>
			</div>

			<div class="form-card-body">
				@php
					$userAccount = null;
					$isEditing = false;
				@endphp
				@include('admin.components.user-account-form-fields')
			</div>

			<div class="form-card-footer">
				<button type="submit" class="btn btn-primary">
					<svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
					</svg>
					Create Account
				</button>
				<a href="{{ route('admin.user-accounts.index') }}" class="btn btn-ghost">Cancel</a>
			</div>
		</div>
	</form>
@endsection

