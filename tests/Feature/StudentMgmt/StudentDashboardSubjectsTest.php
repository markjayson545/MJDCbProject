<?php

use App\Http\Middleware\DownForMaintenanceMW;
use App\Http\Middleware\EnsureStudentPasswordIsUpdated;
use App\Http\Middleware\EnsureUserAccountIsAuthenticated;
use App\Http\Middleware\EnsureUserAccountRole;
use App\Http\Middleware\RouteGuard;
use App\Models\Course;
use App\Models\Degree;
use App\Models\Student;

test('it shows degree subjects on the student dashboard', function () {
    $degree = Degree::query()->create([
        'name' => 'Bachelor of Science in Computer Science',
    ]);

    $courseA = Course::query()->create(['title' => 'Data Structures']);
    $courseB = Course::query()->create(['title' => 'Operating Systems']);

    $degree->courses()->sync([$courseA->id, $courseB->id]);

    $student = Student::query()->create([
        'fname' => 'Alyssa',
        'mname' => null,
        'lname' => 'Diaz',
        'contactno' => '09123456701',
        'email' => 'alyssa.diaz@example.com',
        'description' => 'Dashboard subject test',
        'degree_id' => $degree->id,
    ]);

    $response = $this->withoutMiddleware([
        DownForMaintenanceMW::class,
        EnsureStudentPasswordIsUpdated::class,
        EnsureUserAccountIsAuthenticated::class,
        EnsureUserAccountRole::class,
        RouteGuard::class,
    ])
        ->withSession(['student_id' => $student->id])
        ->get(route('student.dashboard'));

    $response->assertSuccessful()
        ->assertSee('Degree Subjects')
        ->assertSee('Data Structures')
        ->assertSee('Operating Systems');
});
