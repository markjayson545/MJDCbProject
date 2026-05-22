@extends('layouts.app')

@section('title', 'User Account Management — MJDC')

@section('page-title', 'User Account Management')
@section('page-subtitle', 'Manage admin, student, and teacher logins')

@section('content')
    @include('admin.components.alerts')

    <div id="ajax-feedback" class="ff-hint" style="display:none;margin-bottom:12px;"></div>
    <div id="user-account-ajax-root"></div>

    @php
        $accountCount = method_exists($userAccounts ?? null, 'total')
            ? $userAccounts->total()
            : count($userAccounts ?? []);
    @endphp

    <div class="list-toolbar">
        <span class="list-count">
            <strong id="user-account-count">{{ $accountCount }}</strong>
            <span id="user-account-count-label">account{{ $accountCount !== 1 ? 's' : '' }} found</span>
        </span>
        <button type="button" id="open-create-account-modal" class="btn btn-primary">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Add User Account
        </button>
        @include('admin.components.export-buttons', ['dataset' => 'user-accounts'])
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
            <tbody id="user-account-table-body">
            @forelse($userAccounts ?? [] as $userAccount)
                <tr data-user-row-id="{{ $userAccount['id'] }}">
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
                        <button
                            type="button"
                            class="link-btn link-view js-open-view-modal"
                            data-user-id="{{ $userAccount['id'] }}"
                            title="View account details"
                        >
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            View
                        </button>
                        <button
                            type="button"
                            class="link-btn link-edit js-open-edit-modal"
                            data-user-id="{{ $userAccount['id'] }}"
                        >
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </button>
                        <button
                            type="button"
                            class="link-btn link-del js-open-delete-modal"
                            data-user-id="{{ $userAccount['id'] }}"
                            data-username="{{ $userAccount['username'] }}"
                            data-has-dependency="{{ (! empty($userAccount['student']) || ! empty($userAccount['teacher'])) ? 'true' : 'false' }}"
                            data-dependency-type="{{ ! empty($userAccount['student']) ? 'student' : (! empty($userAccount['teacher']) ? 'teacher' : 'none') }}"
                            data-dependency-name="{{ ! empty($userAccount['student']) ? $userAccount['student']['fname'].' '.$userAccount['student']['lname'] : (! empty($userAccount['teacher']) ? $userAccount['teacher']['fname'].' '.$userAccount['teacher']['lname'] : '') }}"
                        >
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete
                        </button>
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

    @if(method_exists($userAccounts ?? null, 'links'))
        <div id="user-account-pagination" style="margin-top:16px;">{{ $userAccounts->links() }}</div>
    @endif


    <style>
        .ajax-modal {
            position: fixed;
            inset: 0;
            z-index: 100;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            overflow-y: auto;
            padding: 40px 16px;
        }

        .ajax-modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 100;
            background: rgba(2, 6, 23, 0.72);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }

        .ajax-modal-card {
            position: relative;
            z-index: 101;
            width: 100%;
            max-width: 760px;
            background: linear-gradient(170deg, rgba(15, 23, 42, 0.96), rgba(2, 6, 23, 0.94));
            border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 14px;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.5);
        }

        .ajax-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid rgba(148, 163, 184, 0.2);
        }

        .ajax-modal-header h3 {
            margin: 0;
            color: var(--clr-text, #f8fafc);
            font-family: 'Fira Code', monospace;
            font-size: 0.92rem;
        }

        #dependency-modal {
            z-index: 110;
        }

        #dependency-modal .ajax-modal-overlay {
            z-index: 110;
        }

        #dependency-modal .ajax-modal-card {
            z-index: 111;
        }

        .ff-group .btn.btn-ghost {
            margin-top: 8px;
        }
    </style>

    @php
        $userAccountAjaxConfig = [
            'roles' => $roles ?? [],
            'students' => $students ?? [],
            'teachers' => $teachers ?? [],
            'endpoints' => [
                'store' => route('admin.user-accounts.store'),
                'show' => route('admin.user-accounts.show', ':id'),
                'update' => route('admin.user-accounts.update', ':id'),
                'destroy' => route('admin.user-accounts.destroy', ':id'),
                    'storeStudentDependency' => route('admin.user-accounts.student-dependencies.store'),
                    'storeTeacherDependency' => route('admin.user-accounts.teacher-dependencies.store'),
            ],
        ];
    @endphp
    <script type="application/json" id="user-account-ajax-config">@json($userAccountAjaxConfig)</script>
@endsection

<div id="view-account-modal" class="ajax-modal" style="display:none;">
    <div class="ajax-modal-overlay"></div>
    <div class="ajax-modal-card" style="max-width:560px;">
        <div class="ajax-modal-header">
            <h3>User Account Details</h3>
            <button type="button" class="btn btn-ghost js-close-view-modal">Close</button>
        </div>
        <div class="form-card-body" id="view-account-content">
            <p class="ff-hint">Loading account details...</p>
        </div>
    </div>
</div>

<div id="user-account-modal" class="ajax-modal" style="display:none;">
    <div class="ajax-modal-overlay"></div>
    <div class="ajax-modal-card">
        <div class="ajax-modal-header">
            <h3 id="account-modal-title">Create User Account</h3>
            <button type="button" class="btn btn-ghost js-close-account-modal">Close</button>
        </div>

{{--        <form id="user-account-ajax-form" method="POST">--}}
{{--            @csrf--}}
            <input type="hidden" id="account-form-method" name="_method" value="POST">
            <input type="hidden" id="account-form-user-id" value="">

            <div class="form-card-body">
                <div id="account-form-errors" class="ff-hint" style="color:#ef4444;display:none;margin-bottom:10px;"></div>

                <div class="ff-group">
                    <label for="modal_username">Username <span class="req">*</span></label>
                    <input type="text" id="modal_username" name="username" required>
                </div>

                <div class="ff-group">
                    <label for="modal_email">Email <span class="req">*</span></label>
                    <input type="email" id="modal_email" name="email" required>
                </div>

                <div class="ff-group">
                    <label for="modal_role">Role <span class="req">*</span></label>
                    <select id="modal_role" name="role" required></select>
                    <span id="role-help-text" class="ff-hint"></span>
                </div>

                <div class="ff-group" id="student-dependency-group" style="display:none;">
                    <label for="modal_student_id">Student Dependency</label>
                    <select id="modal_student_id" name="student_id"></select>
                    <span class="ff-hint">Select the student record that should own this login.</span>
                    <button type="button" class="btn btn-ghost js-open-dependency-modal" data-dependency-type="student">
                        Create Student Dependency
                    </button>
                </div>

                <div class="ff-group" id="teacher-dependency-group" style="display:none;">
                    <label for="modal_teacher_id">Teacher Dependency</label>
                    <select id="modal_teacher_id" name="teacher_id"></select>
                    <span class="ff-hint">Select the teacher record that should own this login.</span>
                    <button type="button" class="btn btn-ghost js-open-dependency-modal" data-dependency-type="teacher">
                        Create Teacher Dependency
                    </button>
                </div>

                <div class="ff-group">
                    <label class="ff-checkbox-item" for="modal_is_active">
                        <input type="checkbox" id="modal_is_active" name="is_active" value="1" checked>
                        <span>Account Active</span>
                    </label>
                </div>

                <div class="ff-group">
                    <label for="modal_password">Password <span class="req" id="password-required-marker">*</span></label>
                    <input type="password" id="modal_password" name="password">
                    <span class="ff-hint" id="password-help-text">Required for new accounts.</span>
                </div>

                <div class="ff-group">
                    <label for="modal_password_confirmation">Confirm Password <span class="req" id="password-confirm-required-marker">*</span></label>
                    <input type="password" id="modal_password_confirmation" name="password_confirmation">
                </div>
            </div>

            <div class="form-card-footer">
                <button class="btn btn-primary" id="account-submit-button">Create Account</button>
                <button type="button" class="btn btn-ghost js-close-account-modal">Cancel</button>
            </div>
{{--        </form>--}}
    </div>
</div>

<div id="delete-account-modal" class="ajax-modal" style="display:none;">
    <div class="ajax-modal-overlay"></div>
    <div class="ajax-modal-card" style="max-width:480px;">
        <div class="ajax-modal-header">
            <h3>Delete User Account</h3>
            <button type="button" class="btn btn-ghost js-close-delete-modal">Close</button>
        </div>
        <div class="form-card-body">
            <p id="delete-dependency-warning" class="main-alert warning" style="display:none; margin-bottom:1.5rem; text-align:left;">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span><strong>Note:</strong> This account is linked to <span id="dependency-type-display"></span>: <strong id="dependency-name-display"></strong>. Deleting this account will also delete the linked record.</span>
            </p>
            <p>You are about to delete user account <strong id="delete-account-name"></strong>.</p>
            <p class="ff-hint">This action cannot be undone and will permanently remove this login and its associated profile.</p>
        </div>
        <div class="form-card-footer">
            <button type="button" class="btn btn-danger" id="confirm-delete-account">Delete</button>
            <button type="button" class="btn btn-ghost js-close-delete-modal">Cancel</button>
        </div>
    </div>
</div>

<div id="dependency-modal" class="ajax-modal" style="display:none;">
    <div class="ajax-modal-overlay"></div>
    <div class="ajax-modal-card">
        <div class="ajax-modal-header">
            <h3 id="dependency-modal-title">Create Dependency</h3>
            <button type="button" class="btn btn-ghost js-close-dependency-modal">Close</button>
        </div>
            <input type="hidden" id="dependency-form-type" name="dependency_type" value="student">

            <div class="form-card-body">
                <div id="dependency-form-errors" class="ff-hint" style="color:#ef4444;display:none;margin-bottom:10px;"></div>

                <div class="ff-group">
                    <label for="dependency_fname">First Name <span class="req">*</span></label>
                    <input type="text" id="dependency_fname" name="fname" required>
                </div>

                <div class="ff-group">
                    <label for="dependency_mname">Middle Name</label>
                    <input type="text" id="dependency_mname" name="mname">
                </div>

                <div class="ff-group">
                    <label for="dependency_lname">Last Name <span class="req">*</span></label>
                    <input type="text" id="dependency_lname" name="lname" required>
                </div>

                <div class="ff-group">
                    <label for="dependency_contactno">Contact Number <span class="req">*</span></label>
                    <input type="text" id="dependency_contactno" name="contactno" required>
                </div>

                <div class="ff-group">
                    <label for="dependency_email">Email <span class="req">*</span></label>
                    <input type="email" id="dependency_email" name="email" required>
                </div>

                <div class="ff-group" id="dependency_department_group" style="display:none;">
                    <label for="dependency_department">Department</label>
                    <input type="text" id="dependency_department" name="department">
                </div>

                <div class="ff-group">
                    <label for="dependency_description">Description</label>
                    <textarea id="dependency_description" name="description" placeholder="Optional notes..."></textarea>
                </div>
            </div>

            <div class="form-card-footer">
                <button class="btn btn-primary" id="dependency-submit-button">Create Dependency</button>
                <button type="button" class="btn btn-ghost js-close-dependency-modal">Cancel</button>
            </div>
    </div>
</div>
