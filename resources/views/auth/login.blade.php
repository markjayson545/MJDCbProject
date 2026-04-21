<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')"/>


    <div class="space-y-4">
        <!-- Header Section -->
        <div class="text-center mb-6">
            <h1 class="text-xl font-bold mb-2 text-white">
                <span class="text-cyan-400">// </span>Access Portal
            </h1>
            <p class="text-slate-400 text-sm">Enter your credentials to continue</p>
        </div>

        <!-- General Error Messages -->
        @if ($errors->any())
            <div class="p-4 bg-red-500/10 border border-red-500/30 rounded-lg">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-red-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-red-400 mb-2">Login Failed</h3>
                        <ul class="space-y-2">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm text-red-300">• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('login.authenticate') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="username" :value="__('Username')"/>
                <x-text-input
                    id="username"
                    class="block w-full mt-1"
                    type="text"
                    name="username"
                    :value="old('username')"
                    required
                    autofocus
                    autocomplete="username"
                />
                <x-input-error :messages="$errors->get('username')" class="mt-2"/>
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')"/>
                <x-text-input
                    id="password"
                    class="block w-full mt-1"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
            </div>

            <!-- Remember Me -->
            {{--            <div class="flex items-center">--}}
            {{--                <input--}}
            {{--                    id="remember_me"--}}
            {{--                    type="checkbox"--}}
            {{--                    class="rounded border-slate-600 text-green-500 shadow-sm focus:ring-green-500 accent-green-500"--}}
            {{--                    name="remember"--}}
            {{--                />--}}
            {{--                <label for="remember_me" class="ms-2 text-sm text-slate-400">--}}
            {{--                    {{ __('Remember me') }}--}}
            {{--                </label>--}}
            {{--            </div>--}}

            <!-- Actions -->
            <div class="flex items-center justify-center pt-2">
                {{--                @if (Route::has('password.request'))--}}
                {{--                    <a--}}
                {{--                        class="underline text-sm text-cyan-400 hover:text-cyan-300 transition-colors"--}}
                {{--                        href="{{ route('password.request') }}"--}}
                {{--                    >--}}
                {{--                        {{ __('Forgot your password?') }}--}}
                {{--                    </a>--}}
                {{--                @endif--}}

                <button type="submit"
                        class="ms-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-400 transition-colors">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>

        <!-- Sign Up Link -->
        <div class="text-center pt-2 border-t border-slate-700">
            <p class="text-slate-400 text-sm">
                Don't have an account?
                <a href="{{ route('register') }}"
                   class="text-green-400 hover:text-green-300 font-semibold transition-colors">
                    Sign up here
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>

