<?php

use App\Models\Teacher;
use App\Models\UserAccount;
use Tests\TestCase;

it('redirects to teacher dashboard after teacher login', function () {
    $userAccount = UserAccount::factory()->create([
        'username' => 'test_teacher',
        'role' => 'teacher',
        'is_active' => true,
    ]);

    $teacher = Teacher::factory()->create([
        'user_account_id' => $userAccount->id,
    ]);

    $response = $this->post(route('login.authenticate'), [
        'username' => 'test_teacher',
        'password' => 'password', // default from factory
    ]);

    $response->assertRedirect(route('teacher.dashboard', absolute: false));
    expect(session('teacher_id'))->toBe($teacher->id);
});

it('displays teacher dashboard with courses', function () {
    $userAccount = UserAccount::factory()->create([
        'username' => 'teacher_with_courses',
        'role' => 'teacher',
        'is_active' => true,
    ]);

    $teacher = Teacher::factory()->create([
        'user_account_id' => $userAccount->id,
    ]);

    $response = $this->withSession([
        'user_account_id' => $userAccount->id,
        'user_account_role' => 'teacher',
        'teacher_id' => $teacher->id,
        'teacher' => $teacher,
    ])->get(route('teacher.dashboard'));

    $response->assertSuccessful();
});

it('returns 404 when teacher profile not found', function () {
    $userAccount = UserAccount::factory()->create([
        'username' => 'orphan_teacher',
        'role' => 'teacher',
        'is_active' => true,
    ]);

    // No teacher profile linked to this account

    $response = $this->post(route('login.authenticate'), [
        'username' => 'orphan_teacher',
        'password' => 'password',
    ]);

    $response->assertRedirect('/');
    $response->assertSessionHasErrors(['general' => 'Teacher profile not found. Please contact the administrator.']);
});


