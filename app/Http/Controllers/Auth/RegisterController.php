<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Validator;

use function PHPUnit\Framework\throwException;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function show(): View
    {
        return view('auth.register');
    }

    /**
     * Handle user registration and profile creation.
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'username' => ['required', 'string', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ]
            );

            if ($validator->fails()) {
                Log::error($validator->errors());
                throwException(new \Exception('Validation failed.'));
            }

            return redirect()
                ->route('login')
                ->with('success', 'Registration successful! Please log in with your credentials.');
        } catch (\Throwable $throwable) {
            Log::error('User registration failed.', [
                'error' => $throwable->getMessage(),
                'email' => $request->string('email')->toString(),
            ]);

            return redirect()
                ->route('register')
                ->withErrors([
                    'general' => 'Registration failed. Please try again.',
                ])
                ->withInput();
        }
    }
}
