<?php

use App\Models\UserAccount;
use Illuminate\Support\Facades\Hash;

test('admin can view user accounts list', function () {
    $admin = UserAccount::factory()->create(['role' => 'admin']);
    $userAccount = UserAccount::factory()->create(['role' => 'teacher']);

    $this->withSession([
        'user_account_id' => $admin->id,
        'user_account_role' => 'admin',
    ])
        ->get(route('admin.user-accounts.index'))
        ->assertSuccessful()
        ->assertSee($userAccount->username);
});

test('admin can create a user account', function () {
    $admin = UserAccount::factory()->create(['role' => 'admin']);

    $payload = [
        'username' => 'teacher-one',
        'email' => 'teacher1@example.com',
        'role' => 'teacher',
        'is_active' => 1,
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $this->withSession([
        'user_account_id' => $admin->id,
        'user_account_role' => 'admin',
    ])
        ->post(route('admin.user-accounts.store'), $payload)
        ->assertRedirect(route('admin.user-accounts.index'));

    $this->assertDatabaseHas('user_accounts', [
        'username' => 'teacher-one',
        'email' => 'teacher1@example.com',
        'role' => 'teacher',
        'is_active' => 1,
    ]);

    $userAccount = UserAccount::query()->where('username', 'teacher-one')->first();

    expect($userAccount)->not->toBeNull()
        ->and(Hash::check('password123', $userAccount->password))->toBeTrue();
});

test('admin can update a user account', function () {
    $admin = UserAccount::factory()->create(['role' => 'admin']);
    $userAccount = UserAccount::factory()->create(['role' => 'student']);

    $payload = [
        'username' => 'updated-username',
        'email' => 'updated@example.com',
        'role' => 'admin',
        'is_active' => 0,
    ];

    $this->withSession([
        'user_account_id' => $admin->id,
        'user_account_role' => 'admin',
    ])
        ->put(route('admin.user-accounts.update', $userAccount->id), $payload)
        ->assertRedirect(route('admin.user-accounts.edit', $userAccount->id));

    $this->assertDatabaseHas('user_accounts', [
        'id' => $userAccount->id,
        'username' => 'updated-username',
        'email' => 'updated@example.com',
        'role' => 'admin',
        'is_active' => 0,
    ]);
});

test('admin can delete a user account', function () {
    $admin = UserAccount::factory()->create(['role' => 'admin']);
    $userAccount = UserAccount::factory()->create(['role' => 'teacher']);

    $this->withSession([
        'user_account_id' => $admin->id,
        'user_account_role' => 'admin',
    ])
        ->delete(route('admin.user-accounts.destroy', $userAccount->id))
        ->assertRedirect(route('admin.user-accounts.index'));

    $this->assertDatabaseMissing('user_accounts', ['id' => $userAccount->id]);
});
