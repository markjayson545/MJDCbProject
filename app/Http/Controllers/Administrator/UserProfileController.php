<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Archived\Controller;
use App\Http\Requests\StudentMgmt\StoreUserProfileRequest;
use App\Http\Requests\StudentMgmt\UpdateUserProfileRequest;
use App\Models\UserProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $profiles = UserProfile::query()->with('student')->orderBy('username', 'asc')->paginate(10);

        return view('admin.user_profile.profiles')->with('profiles', $profiles);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.user_profile.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserProfileRequest $request): RedirectResponse
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:user_profiles,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        try {
            UserProfile::query()->create([
                'username' => $request->string('username')->toString(),
                'password' => Hash::make($request->string('password')->toString()),
            ]);
            Log::info('Successfully created user profile.', ['username' => $request->string('username')->toString()]);
        } catch (\Throwable $throwable) {
            Log::error('Failed to create user profile.', ['error' => $throwable->getMessage()]);

            return redirect()->route('admin.user-profiles.create')
                ->withErrors([
                    'username' => 'Unable to save this username. Please try a different one.',
                    'password' => 'Please review your password and try again.',
                ])
                ->withInput()
                ->with('error', 'Failed to create user profile.');
        }

        return redirect()->route('admin.user-profiles.index')->with('success', 'User profile created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): RedirectResponse
    {
        return redirect()->route('admin.user-profiles.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|RedirectResponse
    {
        $profile = UserProfile::query()->find($id);

        if (! $profile) {
            return redirect()->route('admin.user-profiles.index')->with('error', 'User profile not found.');
        }

        return view('admin.user_profile.edit')->with('profile', $profile->toArray());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserProfileRequest $request, string $id): RedirectResponse
    {
        $profile = UserProfile::query()->find($id);

        if (! $profile) {
            return redirect()->route('admin.user-profiles.index')->with('error', 'User profile not found.');
        }

        try {
            $payload = [
                'username' => $request->string('username')->toString(),
            ];

            if ($request->filled('password')) {
                $payload['password'] = Hash::make($request->string('password')->toString());
            }

            $profile->update($payload);
            Log::info('Successfully updated user profile.', ['user_profile_id' => $profile->id]);
        } catch (\Throwable $throwable) {
            Log::error('Failed to update user profile.', ['user_profile_id' => $id, 'error' => $throwable->getMessage()]);

            return redirect()->route('admin.user-profiles.edit', $id)
                ->withErrors([
                    'username' => 'Unable to update this username. Please try a different one.',
                    'password' => 'Unable to update password. Please check your input and try again.',
                ])
                ->withInput()
                ->with('error', 'Failed to update user profile.');
        }

        return redirect()->route('admin.user-profiles.edit', $id)->with('success', 'User profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $profile = UserProfile::query()->with('student')->find($id);

        if (! $profile) {
            return redirect()->route('admin.user-profiles.index')->with('error', 'User profile not found.');
        }

        if ($profile->student) {
            return redirect()->route('admin.user-profiles.index')->with('error', 'Cannot delete a user profile that is linked to a student.');
        }

        try {
            $profile->delete();
        } catch (\Throwable $throwable) {
            return redirect()->route('admin.user-profiles.index')->with('error', 'Failed to delete user profile: '.$throwable->getMessage());
        }

        return redirect()->route('admin.user-profiles.index')->with('success', 'User profile deleted successfully.');
    }
}
