<?php

use App\Models\Student;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;

test('it creates a user profile from management page', function () {
    $response = $this->post(route('admin.user-profiles.store'), [
        'username' => 'student_profile_1',
        'password' => 'secret-pass-123',
        'password_confirmation' => 'secret-pass-123',
    ]);

    $response->assertRedirect(route('admin.user-profiles.index'));

    $profile = UserProfile::query()->where('username', 'student_profile_1')->first();

    expect($profile)->not->toBeNull();
    expect(Hash::check('secret-pass-123', $profile->password))->toBeTrue();
});

test('it validates required fields when creating a user profile', function () {
    $response = $this->from(route('admin.user-profiles.create'))->post(route('admin.user-profiles.store'), [
        'username' => 'ab',
        'password' => 'short',
        'password_confirmation' => 'different',
    ]);

    $response->assertRedirect(route('admin.user-profiles.create'));
    $response->assertSessionHasErrors(['username', 'password']);
});

test('it links a student to a user profile during student creation', function () {
    $profile = UserProfile::query()->create([
        'username' => 'linked_profile',
        'password' => Hash::make('secret-pass-123'),
    ]);

    $response = $this->post(route('admin.students.store'), [
        'fname' => 'Juan',
        'mname' => 'Santos',
        'lname' => 'Dela Cruz',
        'contactno' => '09123456789',
        'email' => 'juan@example.com',
        'description' => 'Sample',
        'user_profile_id' => $profile->id,
        'course_ids' => [],
    ]);

    $response->assertRedirect(route('admin.students.index'));

    $student = Student::query()->where('email', 'juan@example.com')->first();

    expect($student)->not->toBeNull();
    expect($student->user_profile_id)->toBe($profile->id);
});

test('it prevents deleting a linked user profile', function () {
    $profile = UserProfile::query()->create([
        'username' => 'protected_profile',
        'password' => Hash::make('secret-pass-123'),
    ]);

    Student::query()->create([
        'fname' => 'Maria',
        'mname' => 'Dela',
        'lname' => 'Rosa',
        'contactno' => '09123456788',
        'email' => 'maria@example.com',
        'description' => 'Linked to profile',
        'user_profile_id' => $profile->id,
    ]);

    $response = $this->delete(route('admin.user-profiles.destroy', $profile->id));

    $response->assertRedirect(route('admin.user-profiles.index'));
    $response->assertSessionHas('error');
    $this->assertDatabaseHas('user_profiles', ['id' => $profile->id]);
});

test('it validates update payload for a user profile', function () {
    $profile = UserProfile::query()->create([
        'username' => 'valid_profile',
        'password' => Hash::make('secret-pass-123'),
    ]);

    $response = $this->from(route('admin.user-profiles.edit', $profile->id))->put(route('admin.user-profiles.update', $profile->id), [
        'username' => 'a',
        'password' => 'short',
        'password_confirmation' => 'mismatch',
    ]);

    $response->assertRedirect(route('admin.user-profiles.edit', $profile->id));
    $response->assertSessionHasErrors(['username', 'password']);
});
