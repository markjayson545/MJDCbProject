<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\UserAccount;
use Hash;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function login(Request $request)
    {
        return view('auth.login');
    }

    public function showUpdatePasswordForm(Request $request)
    {
        $userId = session('user_id');
        $user = UserAccount::find($userId);

        if (! $user) {
            return redirect()->route('login')->withErrors(['general' => 'User not found.']);
        }

        return view('auth.update-password', ['user' => $user]);
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username' => ['required', 'string'],
                'password' => ['required', 'string'],
            ],
            [
                'username.required' => 'Please enter your username to continue.',
                'password.required' => 'Please enter your password to continue.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $username = $request->input('username');
        $password = $request->input('password');

        try {
            $user = UserAccount::where('username', $username)->first();

            if ($user && Hash::check($password, $user->password)) {
                // Simple RBAC
                if ($user->role == 'student') {
                    return redirect()->route('password.update.page')->with('user_id', $user->id);
                } elseif ($user->role == 'teacher') {
                    return redirect()->route('studentMgmtHome');
                }
            }

            return redirect()->back()->withErrors(['credentials' => 'The username or password you entered is incorrect. Please try again.'])->withInput();
        } catch (\Throwable $throwable) {
            return redirect()->back()->withErrors(['general' => 'An error occurred during login. Please try again or contact support.'])->withInput();
        }
    }

    public function updatePassword(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'current_password' => ['required', 'string'],
                'password' => ['required', 'string', 'confirmed'],
            ],
            [
                'current_password.required' => 'Please enter your current password.',
                'password.required' => 'Please enter your new password.',
                'password.confirmed' => 'Password confirmation does not match.',
            ]
        );

        if ($validator->fails()) {
            $userId = $request->input('user_id') ?? session('user_id');

            return redirect()->route('password.update.page')->with('user_id', $userId)->withErrors($validator)->withInput();
        }

        $userId = $request->input('user_id') ?? session('user_id');
        $currentPassword = $request->input('current_password');
        $newPassword = $request->input('password');

        try {
            $user = UserAccount::find($userId);

            if (! $user) {
                return redirect()->route('password.update.page')->with('user_id', $userId)->withErrors(['general' => 'User not found.'])->withInput();
            }

            if (! Hash::check($currentPassword, $user->password)) {
                return redirect()->route('password.update.page')->with('user_id', $userId)->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
            }

            $user->update([
                'password' => Hash::make($newPassword),
            ]);

            // Fetch student data with relationships if user is a student
            if ($user->role === 'student') {
                $student = Student::query()
                    ->where('user_account_id', $user->id)
                    ->with(['courses', 'degree'])
                    ->first();

                if ($student) {
                    return redirect()->route('studentDashboard', $student->id)->with('status', 'Your password has been updated successfully.');
                }
            }

            return redirect()->route('password.update.page')->with('user_id', $user->id)->with('status', 'Your password has been updated successfully.');
        } catch (\Throwable $throwable) {
            $userId = $request->input('user_id') ?? session('user_id');

            return redirect()->route('password.update.page')->with('user_id', $userId)->withErrors(['general' => 'An error occurred while updating your password. Please try again.'])->withInput();
        }
    }

    public function registerPage(Request $request)
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username' => ['required', 'string'],
                'password' => ['required', 'string'],
                'email' => ['required', 'string'],
            ],
            [
                'username.required' => 'Please enter your username.',
                'password.required' => 'Please enter your password.',
                'email.required' => 'Please enter your email.',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $userId = $request->input('user_id');
        $username = $request->input('username');
        $email = $request->input('email');

        try {
            $user = UserAccount::create([
                'username' => $username,
                'email' => $email,
                'password' => Hash::make($request->input('password')),
                'role' => 'student', // Default role
            ]);

            return redirect()->route('login')->with('status', 'Registration successful. Please log in.');
        } catch (\Throwable $throwable) {
            return redirect()->back()->withErrors(['general' => 'An error occurred during registration. Please try again.'])->withInput();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
