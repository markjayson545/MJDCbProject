<?php

use App\Libraries\AdminExportLibrary;
use App\Models\UserAccount;
use Maatwebsite\Excel\Facades\Excel;

function adminExportSession(UserAccount $admin): array
{
    return [
        'user_account_id' => $admin->id,
        'user_account_role' => 'admin',
        'user_account_name' => $admin->username,
    ];
}

dataset('admin export datasets', [
    'students',
    'teachers',
    'courses',
    'degrees',
    'user-accounts',
    'user-profiles',
    'summary',
]);

it('allows admins to download pdf exports', function (string $dataset) {
    $this->seed();
    $admin = UserAccount::query()->where('username', 'admin')->firstOrFail();

    $this->withSession(adminExportSession($admin))
        ->get(route('admin.exports.pdf', $dataset))
        ->assertSuccessful()
        ->assertDownload($dataset.'-report.pdf');
})->with('admin export datasets');

it('allows admins to download excel exports', function (string $dataset) {
    $this->seed();
    $admin = UserAccount::query()->where('username', 'admin')->firstOrFail();

    Excel::fake();

    $this->withSession(adminExportSession($admin))
        ->get(route('admin.exports.excel', $dataset))
        ->assertSuccessful();

    Excel::assertDownloaded($dataset.'-report.xlsx');
})->with('admin export datasets');

it('blocks non-admin users from export routes', function (string $role) {
    $userAccount = UserAccount::factory()->create([
        'role' => $role,
        'is_active' => true,
    ]);

    $this->withSession([
        'user_account_id' => $userAccount->id,
        'user_account_role' => $role,
    ])->get(route('admin.exports.pdf', 'students'))
        ->assertForbidden();
})->with(['student', 'teacher']);

it('redirects guests away from export routes', function () {
    $this->get(route('admin.exports.pdf', 'students'))
        ->assertRedirect(route('login', absolute: false));
});

it('returns not found for unsupported export datasets', function () {
    $this->seed();
    $admin = UserAccount::query()->where('username', 'admin')->firstOrFail();

    $this->withSession(adminExportSession($admin))
        ->get(route('admin.exports.pdf', 'unknown'))
        ->assertNotFound();
});

it('excludes password and framework operational data from exports', function () {
    $this->seed();

    $exports = app(AdminExportLibrary::class);
    $accountPayload = $exports->rows('user-accounts')->flatten()->implode(' ');
    $summaryPayload = $exports->rows('summary')->flatten()->implode(' ');

    expect($accountPayload)
        ->not->toContain('password123')
        ->not->toContain('admin123')
        ->not->toContain('$2y$')
        ->and($summaryPayload)
        ->not->toContain('sessions')
        ->not->toContain('cache')
        ->not->toContain('jobs')
        ->not->toContain('password_reset_tokens');
});
