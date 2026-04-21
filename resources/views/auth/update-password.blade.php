<x-guest-layout>
    <div class="update-password-container">
        <!-- Header -->
        <div class="update-password-header">
            <h1 class="update-password-title">Update Your Password</h1>
            <p class="update-password-subtitle">Secure your account with a new password</p>
            @if (isset($user))
                <p class="update-password-user">
                    <span class="font-semibold">User:</span>
                    {{ $user->username }}
                </p>
            @endif
        </div>

        <!-- Success Message -->
        @if (session('status'))
            <div class="p-4 bg-green-500/10 border border-green-500/30 rounded-lg">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-green-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-green-400">Success</h3>
                        <p class="text-sm text-green-300 mt-1">{{ session('status') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="p-4 bg-red-500/10 border border-red-500/30 rounded-lg">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-red-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-red-400 mb-2">Update Failed</h3>
                        <ul class="space-y-2">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm text-red-300">• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Update Password Form -->
        <form action="{{ route('password.update') }}" method="POST" class="update-password-form">
            @csrf
            @method('PUT')

            @if (session('user_id'))
                <input type="hidden" name="user_id" value="{{ session('user_id') }}" />
            @endif

            <!-- Current Password Field -->
            <div class="form-group">
                <label for="current_password" class="form-label">
                    Current Password
                    <span class="required-indicator">*</span>
                </label>
                <input
                    type="password"
                    id="current_password"
                    name="current_password"
                    class="form-input @error('current_password') input-error @enderror"
                    required
                    autocomplete="current-password"
                />
                @error('current_password')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- New Password Field -->
            <div class="form-group">
                <label for="password" class="form-label">
                    New Password
                    <span class="required-indicator">*</span>
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-input @error('password') input-error @enderror"
                    required
                    autocomplete="new-password"
                />
                @error('password')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password Field -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">
                    Confirm Password
                    <span class="required-indicator">*</span>
                </label>
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="form-input @error('password_confirmation') input-error @enderror"
                    required
                    autocomplete="new-password"
                />
                @error('password_confirmation')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-update-password">
                Update Password
            </button>

        </form>
    </div>

    <style>
        .update-password-container {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            width: 100%;
        }

        .update-password-header {
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .update-password-title {
            font-size: 1.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, var(--clr-info), var(--clr-accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .update-password-subtitle {
            font-size: 0.95rem;
            color: var(--clr-text-soft);
            margin: 0;
        }

        .update-password-user {
            font-size: 0.9rem;
            color: var(--clr-text);
            margin-top: 0.75rem;
            padding: 0.5rem 0.75rem;
            background-color: rgba(34, 211, 238, 0.1);
            border-left: 2px solid var(--clr-info);
            border-radius: 0.25rem;
        }

        .update-password-form {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--clr-text);
            letter-spacing: 0.01em;
        }

        .required-indicator {
            color: var(--clr-danger);
            font-weight: 600;
        }

        .form-input {
            padding: 0.75rem 1rem;
            border: 1px solid rgba(148, 163, 184, 0.35);
            border-radius: var(--radius-sm);
            background-color: rgba(15, 23, 42, 0.5);
            color: var(--clr-text);
            font-size: 0.95rem;
            transition: all 200ms ease;
            font-family: inherit;
        }

        .form-input::placeholder {
            color: var(--clr-text-muted);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--clr-info);
            background-color: rgba(15, 23, 42, 0.7);
            box-shadow: 0 0 0 3px rgba(34, 211, 238, 0.15);
        }

        .form-input.input-error {
            border-color: var(--clr-danger);
            background-color: rgba(244, 63, 94, 0.08);
        }

        .form-input.input-error:focus {
            box-shadow: 0 0 0 3px rgba(244, 63, 94, 0.15);
        }

        .form-error {
            font-size: 0.8125rem;
            color: var(--clr-danger);
            font-weight: 500;
        }

        .form-hint {
            font-size: 0.8125rem;
            color: var(--clr-text-muted);
            font-weight: 400;
        }

        .btn-update-password {
            padding: 0.875rem 1.5rem;
            border: none;
            border-radius: var(--radius-sm);
            background: linear-gradient(135deg, var(--clr-info), var(--clr-accent));
            color: var(--clr-bg);
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            cursor: pointer;
            transition: all 200ms ease;
            font-family: inherit;
            margin-top: 0.5rem;
        }

        .btn-update-password:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(34, 211, 238, 0.25);
        }

        .btn-update-password:active {
            transform: translateY(0);
            box-shadow: 0 4px 12px rgba(34, 211, 238, 0.2);
        }

        .update-password-footer {
            margin-top: 1rem;
            text-align: center;
        }

        .update-password-cancel-link {
            font-size: 0.875rem;
            color: var(--clr-text-soft);
            text-decoration: none;
            transition: all 200ms ease;
        }

        .update-password-cancel-link:hover {
            color: var(--clr-accent);
        }

        @media (max-width: 640px) {
            .update-password-title {
                font-size: 1.5rem;
            }

            .update-password-subtitle {
                font-size: 0.875rem;
            }

            .form-input {
                font-size: 16px;
            }
        }
    </style>
</x-guest-layout>

