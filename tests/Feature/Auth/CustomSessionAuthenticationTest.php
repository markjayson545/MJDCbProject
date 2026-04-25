<?php

use App\Models\Student;
use App\Models\UserAccount;
use Illuminate\Support\Facades\Hash;

it('redirects admin accounts to the admin dashboard', function () {
    $admin = UserAccount::query()->create([
        'username' => 'admin_user',
        'email' => 'admin@example.com',
        'role' => 'admin',
        'password' => Hash::make('secret-pass'),
    ]);

    $response = $this->post(route('login.authenticate'), [
        'username' => $admin->username,
        'password' => 'secret-pass',
    ]);

    $response->assertRedirect(route('admin.dashboard', absolute: false));
    $this->assertSame($admin->id, session('user_account_id'));
    $this->assertSame('admin', session('user_account_role'));
});

it('requires a first-time student to update their password', function () {
    $studentAccount = UserAccount::query()->create([
        'username' => 'student_user',
        'email' => 'student@example.com',
        'role' => 'student',
        'password' => Hash::make('secret-pass'),
        'password_changed_at' => null,
    ]);

    Student::query()->create([
        'fname' => 'Maria',
        'mname' => 'S',
        'lname' => 'Santos',
        'contactno' => '09123456789',
        'email' => 'maria@example.com',
        'user_account_id' => $studentAccount->id,
    ]);

    $response = $this->post(route('login.authenticate'), [
        'username' => $studentAccount->username,
        'password' => 'secret-pass',
    ]);

    $response->assertRedirect(route('student.password.edit', absolute: false));
    $this->assertSame($studentAccount->id, session('user_account_id'));
    $this->assertSame('student', session('user_account_role'));
    expect(session('student_id'))->not->toBeNull();
});

it('redirects returning students to the session-backed dashboard', function () {
    $studentAccount = UserAccount::query()->create([
        'username' => 'returning_student',
        'email' => 'returning@example.com',
        'role' => 'student',
        'password' => Hash::make('secret-pass'),
        'password_changed_at' => now(),
    ]);

    Student::query()->create([
        'fname' => 'Juan',
        'mname' => 'D',
        'lname' => 'Dela Cruz',
        'contactno' => '09123456780',
        'email' => 'juan@example.com',
        'user_account_id' => $studentAccount->id,
    ]);

    $response = $this->post(route('login.authenticate'), [
        'username' => $studentAccount->username,
        'password' => 'secret-pass',
    ]);

    $response->assertRedirect(route('student.dashboard', absolute: false));

    $dashboardResponse = $this->get(route('student.dashboard'));

    $dashboardResponse->assertSuccessful()
        ->assertSee('Student Dashboard')
        ->assertSee('Juan');

    expect(session('student_id'))->not->toBeNull();
    expect(session('student'))->not->toBeNull();
});

it('sends a student to the dashboard after changing their first password', function () {
    $studentAccount = UserAccount::query()->create([
        'username' => 'first_login_student',
        'email' => 'first-login@example.com',
        'role' => 'student',
        'password' => Hash::make('secret-pass'),
        'password_changed_at' => null,
    ]);

    $student = Student::query()->create([
        'fname' => 'Ana',
        'mname' => 'L',
        'lname' => 'Lopez',
        'contactno' => '09123456781',
        'email' => 'ana@example.com',
        'user_account_id' => $studentAccount->id,
    ]);

    $this->withSession([
        'user_account_id' => $studentAccount->id,
        'user_account_role' => 'student',
        'student_id' => $student->id,
    ]);

    $response = $this->put(route('student.password.update'), [
        'current_password' => 'secret-pass',
        'password' => 'new-secret-pass',
        'password_confirmation' => 'new-secret-pass',
    ]);

    $response->assertRedirect(route('student.dashboard', absolute: false));

    expect($studentAccount->fresh()->password_changed_at)->not->toBeNull();
    expect(session('student_id'))->not->toBeNull();
    expect(session('student'))->not->toBeNull();
});

it('blocks students from admin routes', function () {
    $studentAccount = UserAccount::query()->create([
        'username' => 'guarded_student',
        'email' => 'guarded-student@example.com',
        'role' => 'student',
        'password' => Hash::make('secret-pass'),
        'password_changed_at' => now(),
    ]);

    $this->withSession([
        'user_account_id' => $studentAccount->id,
        'user_account_role' => 'student',
    ]);

    $response = $this->get(route('admin.dashboard'));

    $response->assertForbidden();
});

it('blocks admins from student routes', function () {
    $admin = UserAccount::query()->create([
        'username' => 'guarded_admin',
        'email' => 'guarded-admin@example.com',
        'role' => 'admin',
        'password' => Hash::make('secret-pass'),
    ]);

    $this->withSession([
        'user_account_id' => $admin->id,
        'user_account_role' => 'admin',
    ]);

    $response = $this->get(route('student.dashboard'));

    $response->assertForbidden();
});

it('removes the old student management urls', function () {
    $this->get('/studentMgmt')->assertNotFound();
    $this->get('/student-management')->assertNotFound();
    $this->get('/studentdashboard')->assertNotFound();
});
