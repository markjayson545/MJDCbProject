<?php

use App\Http\Middleware\EnsureUserAccountIsAuthenticated;
use App\Http\Middleware\EnsureUserAccountRole;
use App\Http\Middleware\RouteGuard;
use App\Models\Course;
use App\Models\Degree;
use App\Models\Student;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;

test('it displays linked profile and degree subjects on student details page', function () {
    $profile = UserProfile::query()->create([
        'username' => 'pivot_profile',
        'password' => Hash::make('secret-pass-123'),
    ]);

    $degree = Degree::query()->create([
        'name' => 'Bachelor of Science in Information Technology',
    ]);

    $student = Student::query()->create([
        'fname' => 'Pedro',
        'mname' => 'R',
        'lname' => 'Reyes',
        'contactno' => '09123456787',
        'email' => 'pedro@example.com',
        'description' => 'Pivot test student',
        'user_profile_id' => $profile->id,
        'degree_id' => $degree->id,
    ]);

    $courseA = Course::query()->create(['title' => 'Web Development']);
    $courseB = Course::query()->create(['title' => 'Database Systems']);

    $degree->courses()->sync([$courseA->id, $courseB->id]);

    $response = $this->withoutMiddleware([
        EnsureUserAccountIsAuthenticated::class,
        EnsureUserAccountRole::class,
        RouteGuard::class,
    ])->get(route('admin.students.show', $student->id));

    $response->assertStatus(200)
        ->assertSee('Linked User Profile')
        ->assertSee('pivot_profile')
        ->assertSee('Degree Subjects')
        ->assertSee('Web Development')
        ->assertSee('Database Systems');
});
