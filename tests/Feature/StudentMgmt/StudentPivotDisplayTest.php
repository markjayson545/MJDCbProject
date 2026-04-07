<?php

use App\Models\Course;
use App\Models\Student;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;

test('it displays linked profile and pivot-backed subjects on student details page', function () {
    $profile = UserProfile::query()->create([
        'username' => 'pivot_profile',
        'password' => Hash::make('secret-pass-123'),
    ]);

    $student = Student::query()->create([
        'fname' => 'Pedro',
        'mname' => 'R',
        'lname' => 'Reyes',
        'contactno' => '09123456787',
        'email' => 'pedro@example.com',
        'description' => 'Pivot test student',
        'user_profile_id' => $profile->id,
    ]);

    $courseA = Course::query()->create(['title' => 'Web Development']);
    $courseB = Course::query()->create(['title' => 'Database Systems']);

    $student->courses()->sync([$courseA->id, $courseB->id]);

    $response = $this->get(route('studentMgmt.show', $student->id));

    $response->assertStatus(200)
        ->assertSee('Linked User Profile')
        ->assertSee('pivot_profile')
        ->assertSee('Subjects (Pivot)')
        ->assertSee('Web Development')
        ->assertSee('Database Systems')
        ->assertSee('Assigned At');
});
