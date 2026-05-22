<?php

use App\Models\Student;
use App\Models\Teacher;
use App\Models\UserAccount;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('stores the student profile picture on the user account', function () {
    Storage::fake('public');

    $userAccount = UserAccount::factory()->create([
        'role' => 'student',
        'is_active' => true,
    ]);

    $student = Student::query()->create([
        'fname' => 'Maria',
        'mname' => null,
        'lname' => 'Santos',
        'contactno' => '09123456789',
        'email' => 'maria.santos@example.com',
        'user_account_id' => $userAccount->id,
    ]);

    $response = $this->withSession([
        'user_account_id' => $userAccount->id,
        'user_account_role' => 'student',
        'student_id' => $student->id,
    ])->post(route('student.upload-profile-picture'), [
        'profile_picture' => UploadedFile::fake()->image('student-avatar.jpg', 600, 600),
    ]);

    $response->assertSuccessful()
        ->assertJson([
            'success' => true,
        ]);

    $userAccount->refresh();

    expect($userAccount->profile_picture_path)->not->toBeNull();
    Storage::disk('public')->assertExists($userAccount->profile_picture_path);
});

it('stores the teacher profile picture on the user account', function () {
    Storage::fake('public');

    $userAccount = UserAccount::factory()->create([
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
    ])->post(route('teacher.upload-profile-picture'), [
        'profile_picture' => UploadedFile::fake()->image('teacher-avatar.jpg', 600, 600),
    ]);

    $response->assertSuccessful()
        ->assertJson([
            'success' => true,
        ]);

    $userAccount->refresh();

    expect($userAccount->profile_picture_path)->not->toBeNull();
    Storage::disk('public')->assertExists($userAccount->profile_picture_path);
});
