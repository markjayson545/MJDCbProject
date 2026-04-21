@extends('layouts.guest')

@section('content')
    <div class="register-container">
        <!-- Header -->
        <div class="register-header">
            <h1 class="register-title">Create Your Account</h1>
            <p class="register-subtitle">Join our coding bootcamp community</p>
        </div>

        <!-- Registration Form -->
        <form action="{{ route('register.user') }}" method="POST" class="register-form">
            @csrf

            <!-- Name Field -->
            <div class="form-group">
                <label for="name" class="form-label">
                    Full Name
                    <span class="required-indicator">*</span>
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-input @error('name') input-error @enderror"
                    value="{{ old('name') }}"
                    placeholder="John Doe"
                    required
                    autocomplete="name"
                />
                @error('name')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email Field -->
            <div class="form-group">
                <label for="email" class="form-label">
                    Email Address
                    <span class="required-indicator">*</span>
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-input @error('email') input-error @enderror"
                    value="{{ old('email') }}"
                    placeholder="you@example.com"
                    required
                    autocomplete="email"
                />
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Username Field -->
            <div class="form-group">
                <label for="username" class="form-label">
                    Username
                    <span class="required-indicator">*</span>
                </label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    class="form-input @error('username') input-error @enderror"
                    value="{{ old('username') }}"
                    placeholder="johndoe123"
                    required
                    autocomplete="username"
                />
                @error('username')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label for="password" class="form-label">
                    Password
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
                <span class="form-hint">Minimum 8 characters with uppercase, lowercase, and numbers</span>
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
            <button type="submit" class="btn-register">
                Create Account
            </button>

            <!-- Login Link -->
            <div class="register-footer">
                <p class="register-footer-text">
                    Already have an account?
                    <a href="{{ route('login') }}" class="register-footer-link">Sign in here</a>
                </p>
            </div>
        </form>
    </div>

    <style>
        .register-container {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            width: 100%;
        }

        .register-header {
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .register-title {
            font-size: 1.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, var(--clr-info), var(--clr-accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .register-subtitle {
            font-size: 0.95rem;
            color: var(--clr-text-soft);
            margin: 0;
        }

        .register-form {
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

        .btn-register {
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

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(34, 211, 238, 0.25);
        }

        .btn-register:active {
            transform: translateY(0);
            box-shadow: 0 4px 12px rgba(34, 211, 238, 0.2);
        }

        .register-footer {
            margin-top: 1rem;
            text-align: center;
        }

        .register-footer-text {
            font-size: 0.875rem;
            color: var(--clr-text-soft);
            margin: 0;
        }

        .register-footer-link {
            color: var(--clr-info);
            font-weight: 600;
            transition: all 200ms ease;
        }

        .register-footer-link:hover {
            color: var(--clr-accent);
        }

        @media (max-width: 640px) {
            .register-title {
                font-size: 1.5rem;
            }

            .register-subtitle {
                font-size: 0.875rem;
            }

            .form-input {
                font-size: 16px;
            }
        }
    </style>
@endsection
