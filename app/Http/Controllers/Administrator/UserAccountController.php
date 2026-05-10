<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Archived\Controller;
use App\Http\Requests\StudentMgmt\StoreUserAccountRequest;
use App\Http\Requests\StudentMgmt\UpdateUserAccountRequest;
use App\Models\UserAccount;
use Illuminate\Http\RedirectResponse;
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

        return view('admin.user_accounts.user_accounts')->with('userAccounts', $userAccounts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.user_accounts.create')->with('roles', $this->roleOptions());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserAccountRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        try {
            $userAccount = UserAccount::query()->create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'role' => $validated['role'],
                'is_active' => (int) ($validated['is_active'] ?? false),
                'password' => Hash::make($validated['password']),
            ]);

            Log::info('Created user account.', ['user_account_id' => $userAccount->id]);
        } catch (\Throwable $throwable) {
            Log::error('Failed to create user account.', ['error' => $throwable->getMessage()]);

            return redirect()->route('admin.user-accounts.create')
                ->withInput()
                ->with('error', 'Failed to create user account: '.$throwable->getMessage());
        }

        return redirect()->route('admin.user-accounts.index')->with('success', 'User account created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View|RedirectResponse
    {
        $userAccount = UserAccount::query()->with(['student', 'teacher'])->find($id);

        if (! $userAccount) {
            return redirect()->route('admin.user-accounts.index')->with('error', 'User account not found.');
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
            ->with('roles', $this->roleOptions());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserAccountRequest $request, string $id): RedirectResponse
    {
        $userAccount = UserAccount::query()->with(['student', 'teacher'])->find($id);

        if (! $userAccount) {
            return redirect()->route('admin.user-accounts.index')->with('error', 'User account not found.');
        }

        $validated = $request->validated();

        try {
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

            Log::info('Updated user account.', ['user_account_id' => $userAccount->id]);
        } catch (\Throwable $throwable) {
            Log::error('Failed to update user account.', ['user_account_id' => $id, 'error' => $throwable->getMessage()]);

            return redirect()->route('admin.user-accounts.edit', $id)
                ->withInput()
                ->with('error', 'Failed to update user account: '.$throwable->getMessage());
        }

        return redirect()->route('admin.user-accounts.edit', $id)->with('success', 'User account updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $userAccount = UserAccount::query()->with(['student', 'teacher'])->find($id);

        if (! $userAccount) {
            return redirect()->route('admin.user-accounts.index')->with('error', 'User account not found.');
        }

        if ($userAccount->student || $userAccount->teacher) {
            return redirect()->route('admin.user-accounts.index')
                ->with('error', 'Cannot delete a user account linked to a student or teacher.');
        }

        try {
            $userAccount->delete();
        } catch (\Throwable $throwable) {
            return redirect()->route('admin.user-accounts.index')
                ->with('error', 'Failed to delete user account: '.$throwable->getMessage());
        }

        return redirect()->route('admin.user-accounts.index')->with('success', 'User account deleted successfully.');
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
}
