<?php

use App\Models\Student;
use App\Models\Teacher;
use App\Models\UserAccount;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

function createStudentUploadContext(): array
{
    $userAccount = UserAccount::factory()->create([
        'role' => 'student',
        'is_active' => true,
    ]);

    $student = Student::factory()->create([
        'user_account_id' => $userAccount->id,
    ]);

    return [$userAccount, [
        'user_account_id' => $userAccount->id,
        'user_account_role' => 'student',
        'student_id' => $student->id,
    ]];
}

function createTeacherUploadContext(): array
{
    $userAccount = UserAccount::factory()->create([
        'role' => 'teacher',
        'is_active' => true,
    ]);

    $teacher = Teacher::factory()->create([
        'user_account_id' => $userAccount->id,
    ]);

    return [$userAccount, [
        'user_account_id' => $userAccount->id,
        'user_account_role' => 'teacher',
        'teacher_id' => $teacher->id,
    ]];
}

it('stores the resized student profile picture on the user account', function () {
    Storage::fake('public');

    [$userAccount, $session] = createStudentUploadContext();

    $response = $this->withSession($session)->post(route('student.upload-profile-picture'), [
        'profile_picture' => UploadedFile::fake()->image('student-avatar.png', 600, 500),
    ]);

    $response->assertSuccessful()
        ->assertJson([
            'success' => true,
        ]);

    $userAccount->refresh();
    [$width, $height] = getimagesize(Storage::disk('public')->path($userAccount->profile_picture_path));

    expect($userAccount->profile_picture_path)->not->toBeNull()
        ->and($userAccount->profile_picture_path)->toMatch('/\.(jpg|png)$/')
        ->and($width)->toBe(300)
        ->and($height)->toBe(300);

    Storage::disk('public')->assertExists($userAccount->profile_picture_path);
});

it('stores the resized teacher profile picture on the user account', function () {
    Storage::fake('public');

    [$userAccount, $session] = createTeacherUploadContext();

    $response = $this->withSession($session)->post(route('teacher.upload-profile-picture'), [
        'profile_picture' => UploadedFile::fake()->image('teacher-avatar.png', 480, 640),
    ]);

    $response->assertSuccessful()
        ->assertJson([
            'success' => true,
        ]);

    $userAccount->refresh();
    [$width, $height] = getimagesize(Storage::disk('public')->path($userAccount->profile_picture_path));

    expect($userAccount->profile_picture_path)->not->toBeNull()
        ->and($width)->toBe(300)
        ->and($height)->toBe(300);

    Storage::disk('public')->assertExists($userAccount->profile_picture_path);
});

it('replaces the old profile picture after a new upload succeeds', function () {
    Storage::fake('public');

    [$userAccount, $session] = createStudentUploadContext();
    $oldPath = 'user-profiles/'.$userAccount->id.'/profile-pictures/old-avatar.jpg';

    Storage::disk('public')->put($oldPath, 'old-avatar');
    $userAccount->update(['profile_picture_path' => $oldPath]);

    $this->withSession($session)->post(route('student.upload-profile-picture'), [
        'profile_picture' => UploadedFile::fake()->image('new-avatar.png', 600, 600),
    ])->assertSuccessful();

    $userAccount->refresh();

    expect($userAccount->profile_picture_path)->not->toBe($oldPath);

    Storage::disk('public')->assertMissing($oldPath);
    Storage::disk('public')->assertExists($userAccount->profile_picture_path);
});

it('rejects invalid profile picture uploads', function () {
    Storage::fake('public');

    [, $session] = createStudentUploadContext();

    $this->withSession($session)->postJson(route('student.upload-profile-picture'), [
        'profile_picture' => UploadedFile::fake()->create('avatar.txt', 8, 'text/plain'),
    ])->assertUnprocessable()
        ->assertJsonValidationErrors('profile_picture');
});
