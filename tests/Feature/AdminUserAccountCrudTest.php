<?php

use App\Models\Student;
use App\Models\Teacher;
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
    $teacher = Teacher::factory()->create();

    $payload = [
        'username' => 'teacher-one',
        'email' => 'teacher1@example.com',
        'role' => 'teacher',
        'teacher_id' => $teacher->id,
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

    $teacher->refresh();
    expect($teacher->user_account_id)->toBe($userAccount->id);
});

test('admin can create a student user account linked to student dependency', function () {
    $admin = UserAccount::factory()->create(['role' => 'admin']);
    $student = Student::query()->create([
        'fname' => 'Juan',
        'mname' => 'S',
        'lname' => 'Dela Cruz',
        'contactno' => '09171234567',
        'email' => 'juan.student@example.com',
        'description' => 'Student dependency',
    ]);

    $payload = [
        'username' => 'student-one',
        'email' => 'student.one@example.com',
        'role' => 'student',
        'student_id' => $student->id,
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

    $studentAccount = UserAccount::query()->where('username', 'student-one')->first();

    expect($studentAccount)->not->toBeNull();

    $student->refresh();
    expect($student->user_account_id)->toBe($studentAccount->id);
});

test('admin can create and load user account through ajax endpoints', function () {
    $admin = UserAccount::factory()->create(['role' => 'admin']);
    $teacher = Teacher::factory()->create();

    $payload = [
        'username' => 'teacher-ajax',
        'email' => 'teacher.ajax@example.com',
        'role' => 'teacher',
        'teacher_id' => $teacher->id,
        'is_active' => 1,
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ];

    $createResponse = $this->withSession([
        'user_account_id' => $admin->id,
        'user_account_role' => 'admin',
    ])
        ->withHeaders([
            'Accept' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest',
        ])
        ->post(route('admin.user-accounts.store'), $payload)
        ->assertCreated()
        ->assertJsonPath('message', 'User account created successfully.');

    $userAccountId = $createResponse->json('userAccount.id');

    $this->withSession([
        'user_account_id' => $admin->id,
        'user_account_role' => 'admin',
    ])
        ->withHeaders([
            'Accept' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest',
        ])
        ->get(route('admin.user-accounts.show', $userAccountId))
        ->assertSuccessful()
        ->assertJsonPath('userAccount.username', 'teacher-ajax')
        ->assertJsonPath('userAccount.role', 'teacher');

    $teacher->refresh();
    expect($teacher->user_account_id)->toBe($userAccountId);
});

test('admin can create student and teacher dependencies from the user account modal', function () {
    $admin = UserAccount::factory()->create(['role' => 'admin']);

    $studentResponse = $this->withSession([
        'user_account_id' => $admin->id,
        'user_account_role' => 'admin',
    ])
        ->withHeaders([
            'Accept' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest',
        ])
        ->post(route('admin.user-accounts.student-dependencies.store'), [
            'fname' => 'Quick',
            'mname' => 'A',
            'lname' => 'Student',
            'contactno' => '09170000001',
            'email' => 'quick.student@example.com',
            'description' => 'Created from user account modal',
        ])
        ->assertCreated()
        ->assertJsonPath('message', 'Student dependency created successfully.');

    $studentId = $studentResponse->json('student.id');

    $teacherResponse = $this->withSession([
        'user_account_id' => $admin->id,
        'user_account_role' => 'admin',
    ])
        ->withHeaders([
            'Accept' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest',
        ])
        ->post(route('admin.user-accounts.teacher-dependencies.store'), [
            'fname' => 'Quick',
            'mname' => 'B',
            'lname' => 'Teacher',
            'contactno' => '09170000002',
            'email' => 'quick.teacher@example.com',
            'department' => 'IT',
            'description' => 'Created from user account modal',
        ])
        ->assertCreated()
        ->assertJsonPath('message', 'Teacher dependency created successfully.');

    $teacherId = $teacherResponse->json('teacher.id');

    $studentAccount = $this->withSession([
        'user_account_id' => $admin->id,
        'user_account_role' => 'admin',
    ])
        ->withHeaders([
            'Accept' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest',
        ])
        ->post(route('admin.user-accounts.store'), [
            'username' => 'quick-student-account',
            'email' => 'quick.student.account@example.com',
            'role' => 'student',
            'student_id' => $studentId,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'is_active' => 1,
        ])
        ->assertCreated()
        ->assertJsonPath('message', 'User account created successfully.');

    $teacherAccount = $this->withSession([
        'user_account_id' => $admin->id,
        'user_account_role' => 'admin',
    ])
        ->withHeaders([
            'Accept' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest',
        ])
        ->post(route('admin.user-accounts.store'), [
            'username' => 'quick-teacher-account',
            'email' => 'quick.teacher.account@example.com',
            'role' => 'teacher',
            'teacher_id' => $teacherId,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'is_active' => 1,
        ])
        ->assertCreated()
        ->assertJsonPath('message', 'User account created successfully.');

    expect($studentAccount)->toBeTruthy();
    expect($teacherAccount)->toBeTruthy();

    $this->assertDatabaseHas('students', [
        'id' => $studentId,
        'user_account_id' => UserAccount::query()->where('username', 'quick-student-account')->value('id'),
    ]);

    $this->assertDatabaseHas('teachers', [
        'id' => $teacherId,
        'user_account_id' => UserAccount::query()->where('username', 'quick-teacher-account')->value('id'),
    ]);
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
