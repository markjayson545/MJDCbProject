<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Archived\Controller;
use App\Http\Requests\StudentMgmt\UpdateMaintenanceSettingsRequest;
use App\Models\MaintenanceSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class MaintenanceSettingsController extends Controller
{
    public function edit(): View
    {
        $settings = MaintenanceSetting::query()->firstOrCreate([], MaintenanceSetting::defaultValues());

        $routeSuggestions = collect(Route::getRoutes()->getRoutes())
            ->map(static fn ($route): string => '/'.$route->uri())
            ->filter(static fn (string $uri): bool => ! str_starts_with($uri, '/_'))
            ->unique()
            ->sort()
            ->values();

        return view('student_mgmt.settings')
            ->with('settings', $settings)
            ->with('routeSuggestions', $routeSuggestions);
    }

    public function update(UpdateMaintenanceSettingsRequest $request): RedirectResponse
    {
        $settings = MaintenanceSetting::query()->firstOrCreate([], MaintenanceSetting::defaultValues());

        $settings->update($request->validated());

        return redirect()
            ->route('studentMgmtSettings.edit')
            ->with('success', 'Maintenance settings updated successfully.');
    }
}
