<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Archived\Controller;
use App\Http\Requests\StudentMgmt\StoreStudentDependencyRequest;
use App\Http\Requests\StudentMgmt\StoreTeacherDependencyRequest;
use App\Http\Requests\StudentMgmt\StoreUserAccountRequest;
use App\Http\Requests\StudentMgmt\UpdateUserAccountRequest;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\UserAccount;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class UserAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $userAccounts = UserAccount::query()
            ->with(['student', 'teacher'])
            ->orderBy('username', 'asc')
            ->paginate(10);

        return view('admin.user_accounts.user_accounts')
            ->with('userAccounts', $userAccounts)
            ->with('roles', $this->roleOptions())
            ->with('students', $this->availableStudents())
            ->with('teachers', $this->availableTeachers());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.user_accounts.create')
            ->with('roles', $this->roleOptions())
            ->with('students', $this->availableStudents())
            ->with('teachers', $this->availableTeachers());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserAccountRequest $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validated();

        try {
            $userAccount = DB::transaction(function () use ($validated) {
                $createdUserAccount = UserAccount::query()->create([
                    'username' => $validated['username'],
                    'email' => $validated['email'],
                    'role' => $validated['role'],
                    'is_active' => (int) ($validated['is_active'] ?? false),
                    'password' => Hash::make($validated['password']),
                ]);

                $this->syncRoleDependency($createdUserAccount, $validated);

                return $createdUserAccount;
            });

            Log::info('Created user account.', ['user_account_id' => $userAccount->id]);

            if ($request->expectsJson()) {
                $userAccount->load(['student', 'teacher']);

                return response()->json([
                    'message' => 'User account created successfully.',
                    'userAccount' => $userAccount->toArray(),
                ], 201);
            }
        } catch (\Throwable $throwable) {
            Log::error('Failed to create user account.', ['error' => $throwable->getMessage()]);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Failed to create user account.',
                    'error' => $throwable->getMessage(),
                ], 500);
            }

            return redirect()->route('admin.user-accounts.create')
                ->withInput()
                ->with('error', 'Failed to create user account: '.$throwable->getMessage());
        }

        return redirect()->route('admin.user-accounts.index')->with('success', 'User account created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id): View|RedirectResponse|JsonResponse
    {
        $userAccount = UserAccount::query()->with(['student', 'teacher'])->find($id);

        if (! $userAccount) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'User account not found.'], 404);
            }

            return redirect()->route('admin.user-accounts.index')->with('error', 'User account not found.');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'userAccount' => $userAccount->toArray(),
                'roles' => $this->roleOptions(),
                'students' => $this->availableStudents($userAccount->student?->id),
                'teachers' => $this->availableTeachers($userAccount->teacher?->id),
            ]);
        }

        return view('admin.user_accounts.show')->with('userAccount', $userAccount->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|RedirectResponse
    {
        $userAccount = UserAccount::query()->with(['student', 'teacher'])->find($id);

        if (! $userAccount) {
            return redirect()->route('admin.user-accounts.index')->with('error', 'User account not found.');
        }

        return view('admin.user_accounts.edit')
            ->with('userAccount', $userAccount->toArray())
            ->with('roles', $this->roleOptions())
            ->with('students', $this->availableStudents($userAccount->student?->id))
            ->with('teachers', $this->availableTeachers($userAccount->teacher?->id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserAccountRequest $request, string $id): RedirectResponse|JsonResponse
    {
        $userAccount = UserAccount::query()->with(['student', 'teacher'])->find($id);

        if (! $userAccount) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'User account not found.'], 404);
            }

            return redirect()->route('admin.user-accounts.index')->with('error', 'User account not found.');
        }

        $validated = $request->validated();

        try {
            DB::transaction(function () use ($request, $userAccount, $validated) {
                $payload = [
                    'username' => $validated['username'],
                    'email' => $validated['email'],
                    'role' => $validated['role'],
                    'is_active' => (int) ($validated['is_active'] ?? false),
                ];

                if ($request->filled('password')) {
                    $payload['password'] = Hash::make($request->string('password')->toString());
                }

                $userAccount->update($payload);
                $userAccount->refresh();

                $this->syncRoleDependency($userAccount, $validated);
            });

            Log::info('Updated user account.', ['user_account_id' => $userAccount->id]);

            if ($request->expectsJson()) {
                $userAccount->load(['student', 'teacher']);

                return response()->json([
                    'message' => 'User account updated successfully.',
                    'userAccount' => $userAccount->toArray(),
                ]);
            }
        } catch (\Throwable $throwable) {
            Log::error('Failed to update user account.', ['user_account_id' => $id, 'error' => $throwable->getMessage()]);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Failed to update user account.',
                    'error' => $throwable->getMessage(),
                ], 500);
            }

            return redirect()->route('admin.user-accounts.edit', $id)
                ->withInput()
                ->with('error', 'Failed to update user account: '.$throwable->getMessage());
        }

        return redirect()->route('admin.user-accounts.edit', $id)->with('success', 'User account updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id): RedirectResponse|JsonResponse
    {
        $userAccount = UserAccount::query()->with(['student', 'teacher'])->find($id);

        if (! $userAccount) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'User account not found.'], 404);
            }

            return redirect()->route('admin.user-accounts.index')->with('error', 'User account not found.');
        }

        try {
            DB::transaction(function () use ($userAccount) {
                // Delete linked student record if it exists
                if ($userAccount->student) {
                    $userAccount->student->delete();
                    Log::info('Deleted linked student record.', ['student_id' => $userAccount->student->id]);
                }

                // Delete linked teacher record if it exists
                if ($userAccount->teacher) {
                    $userAccount->teacher->delete();
                    Log::info('Deleted linked teacher record.', ['teacher_id' => $userAccount->teacher->id]);
                }

                $userAccount->delete();
            });

            Log::info('Successfully deleted user account.', ['user_account_id' => $id]);

            if ($request->expectsJson()) {
                return response()->json(['message' => 'User account and linked records deleted successfully.']);
            }
        } catch (\Throwable $throwable) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Failed to delete user account.',
                    'error' => $throwable->getMessage(),
                ], 500);
            }

            return redirect()->route('admin.user-accounts.index')
                ->with('error', 'Failed to delete user account: '.$throwable->getMessage());
        }

        return redirect()->route('admin.user-accounts.index')->with('success', 'User account deleted successfully.');
    }

    public function storeStudentDependency(StoreStudentDependencyRequest $request): JsonResponse
    {
        $validated = $request->validated();

        try {
            $student = DB::transaction(function () use ($validated) {
                return Student::query()->create([
                    'fname' => $validated['fname'],
                    'mname' => $validated['mname'] ?? null,
                    'lname' => $validated['lname'],
                    'contactno' => $validated['contactno'],
                    'email' => $validated['email'],
                    'description' => $validated['description'] ?? null,
                ]);
            });

            return response()->json([
                'message' => 'Student dependency created successfully.',
                'student' => $student->only(['id', 'fname', 'mname', 'lname', 'email']),
            ], 201);
        } catch (
            \Throwable $throwable
        ) {
            return response()->json([
                'message' => 'Failed to create student dependency.',
                'error' => $throwable->getMessage(),
            ], 500);
        }
    }

    public function storeTeacherDependency(StoreTeacherDependencyRequest $request): JsonResponse
    {
        $validated = $request->validated();

        try {
            $teacher = DB::transaction(function () use ($validated) {
                return Teacher::query()->create([
                    'fname' => $validated['fname'],
                    'mname' => $validated['mname'] ?? null,
                    'lname' => $validated['lname'],
                    'contactno' => $validated['contactno'],
                    'email' => $validated['email'],
                    'department' => $validated['department'] ?? null,
                    'description' => $validated['description'] ?? null,
                ]);
            });

            return response()->json([
                'message' => 'Teacher dependency created successfully.',
                'teacher' => $teacher->only(['id', 'fname', 'mname', 'lname', 'email']),
            ], 201);
        } catch (\Throwable $throwable) {
            return response()->json([
                'message' => 'Failed to create teacher dependency.',
                'error' => $throwable->getMessage(),
            ], 500);
        }
    }

    /**
     * @return array<string, string>
     */
    private function roleOptions(): array
    {
        return [
            'admin' => 'Admin',
            'student' => 'Student',
            'teacher' => 'Teacher',
        ];
    }

    /**
     * @return array<int, array{id: int, fname: string, lname: string, email: string|null}>
     */
    private function availableStudents(?int $includeStudentId = null): array
    {
        return Student::query()
            ->where(function ($query) use ($includeStudentId) {
                $query->whereNull('user_account_id');

                if ($includeStudentId !== null) {
                    $query->orWhere('id', $includeStudentId);
                }
            })
            ->orderBy('lname')
            ->orderBy('fname')
            ->get(['id', 'fname', 'lname', 'email'])
            ->toArray();
    }

    /**
     * @return array<int, array{id: int, fname: string, lname: string, email: string|null}>
     */
    private function availableTeachers(?int $includeTeacherId = null): array
    {
        return Teacher::query()
            ->where(function ($query) use ($includeTeacherId) {
                $query->whereNull('user_account_id');

                if ($includeTeacherId !== null) {
                    $query->orWhere('id', $includeTeacherId);
                }
            })
            ->orderBy('lname')
            ->orderBy('fname')
            ->get(['id', 'fname', 'lname', 'email'])
            ->toArray();
    }

    /**
     * @param array{
     *     role: string,
     *     student_id?: int|null,
     *     teacher_id?: int|null
     * } $validated
     */
    private function syncRoleDependency(UserAccount $userAccount, array $validated): void
    {
        Student::query()
            ->where('user_account_id', $userAccount->id)
            ->update(['user_account_id' => null]);

        Teacher::query()
            ->where('user_account_id', $userAccount->id)
            ->update(['user_account_id' => null]);

        if ($validated['role'] === 'student') {
            $student = Student::query()
                ->whereKey($validated['student_id'])
                ->where(function ($query) use ($userAccount) {
                    $query->whereNull('user_account_id')
                        ->orWhere('user_account_id', $userAccount->id);
                })
                ->first();

            if (! $student) {
                throw new \RuntimeException('Selected student is already linked to another account.');
            }

            $student->update(['user_account_id' => $userAccount->id]);
        }

        if ($validated['role'] === 'teacher') {
            $teacher = Teacher::query()
                ->whereKey($validated['teacher_id'])
                ->where(function ($query) use ($userAccount) {
                    $query->whereNull('user_account_id')
                        ->orWhere('user_account_id', $userAccount->id);
                })
                ->first();

            if (! $teacher) {
                throw new \RuntimeException('Selected teacher is already linked to another account.');
            }

            $teacher->update(['user_account_id' => $userAccount->id]);
        }
    }
}
