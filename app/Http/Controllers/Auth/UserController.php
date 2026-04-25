<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Archived\Controller;
use App\Http\Requests\Auth\CustomLoginRequest;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Models\Student;
use App\Models\UserAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function login(Request $request): View
    {
        return view('auth.login');
    }

    public function showUpdatePasswordForm(Request $request): View|RedirectResponse
    {
        $user = UserAccount::query()->find($request->session()->get('user_account_id'));

        if (! $user) {
            return redirect()->route('login')->withErrors(['general' => 'User not found.']);
        }

        return view('auth.update-password', ['user' => $user]);
    }

    public function authenticate(CustomLoginRequest $request): RedirectResponse
    {
        $username = $request->input('username');
        $password = $request->input('password');

        try {
            $user = UserAccount::query()->where('username', $username)->first();

            if ($user && Hash::check($password, $user->password)) {
                $this->storeUserAccountSession($request, $user);

                if ($user->role === 'student') {
                    if (! $this->storeStudentSession($request, $user->id)) {
                        return redirect()->back()->withErrors([
                            'general' => 'Student profile not found. Please contact the administrator.',
                        ])->withInput();
                    }

                    if ($user->password_changed_at === null) {
                        return redirect()->route('student.password.edit');
                    }

                    return redirect()->route('student.dashboard');
                }

                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                }
            }

            return redirect()->back()->withErrors(['credentials' => 'The username or password you entered is incorrect. Please try again.'])->withInput();
        } catch (\Throwable $throwable) {
            return redirect()->back()->withErrors(['general' => 'An error occurred during login. Please try again or contact support.'])->withInput();
        }
    }

    public function logoutUser()
    {
        // Clear the user account session data
        $this->removeUserAccountSession();

        return redirect()->route('login');
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $userId = $request->session()->get('user_account_id');
        $currentPassword = $request->input('current_password');
        $newPassword = $request->input('password');

        try {
            $user = UserAccount::query()->find($userId);

            if (! $user) {
                return redirect()->route('login')->withErrors(['general' => 'User not found.']);
            }

            if (! Hash::check($currentPassword, $user->password)) {
                return redirect()->route('student.password.edit')->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
            }

            $user->update([
                'password' => Hash::make($newPassword),
                'password_changed_at' => now(),
            ]);

            if ($user->role === 'student') {
                if ($this->refreshStudentSession($request)) {
                    return redirect()->route('student.dashboard')->with('status', 'Your password has been updated successfully.');
                }

                return redirect()->route('student.password.edit')->withErrors(['general' => 'Student profile not found. Please contact the administrator.']);
            }

            return redirect()->route('admin.dashboard')->with('success', 'Your password has been updated successfully.');
        } catch (\Throwable $throwable) {
            return redirect()->route('student.password.edit')->withErrors(['general' => 'An error occurred while updating your password. Please try again.'])->withInput();
        }
    }

    public function registerPage(Request $request)
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'email' => ['required', 'string'],
        ], [
            'username.required' => 'Please enter your username.',
            'password.required' => 'Please enter your password.',
            'email.required' => 'Please enter your email.',
        ]);

        $username = $request->input('username');
        $email = $request->input('email');

        try {
            UserAccount::create([
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

    private function removeUserAccountSession(): void
    {
        Session::flush();
        Session::regenerate(true);
    }

    private function storeUserAccountSession(Request $request, UserAccount $user): void
    {
        $request->session()->regenerate();
        $request->session()->forget(['student', 'student_id']);

        $request->session()->put([
            'user_account_id' => $user->id,
            'user_account_role' => $user->role,
            'user_account_name' => $user->username,
            'user_account_email' => $user->email,
            'user_account_is_active' => $user->is_active,
        ]);
    }

    private function storeStudentSession(Request $request, int $userAccountId): bool
    {
        $student = Student::query()
            ->where('user_account_id', $userAccountId)
            ->with(['courses', 'degree'])
            ->first();

        if (! $student) {
            $request->session()->forget(['student', 'student_id']);

            return false;
        }

        $request->session()->put([
            'student_id' => $student->id,
            'student' => $student,
        ]);

        return true;
    }

    private function refreshStudentSession(Request $request): bool
    {
        $studentId = $request->session()->get('student_id');

        if ($studentId) {
            $student = Student::query()
                ->with(['courses', 'degree'])
                ->find($studentId);

            if ($student) {
                $request->session()->put('student', $student);

                return true;
            }
        }

        $userAccountId = $request->session()->get('user_account_id');

        if (! $userAccountId) {
            $request->session()->forget(['student', 'student_id']);

            return false;
        }

        return $this->storeStudentSession($request, (int) $userAccountId);
    }
}
