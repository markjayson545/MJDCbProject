<?php

use App\Models\Course;
use App\Models\Student;

test('it displays pivot linked students on course details page', function () {
    $course = Course::query()->create(['title' => 'Algorithms']);

    $student = Student::query()->create([
        'fname' => 'Ana',
        'mname' => null,
        'lname' => 'Santos',
        'contactno' => '09123456700',
        'email' => 'ana.santos@example.com',
        'description' => 'Course pivot student',
    ]);

    $course->students()->sync([$student->id]);

    $response = $this->get(route('courses.show', $course->id));

    $response->assertStatus(200)
        ->assertSee('Students (Pivot)')
        ->assertSee('Santos, Ana')
        ->assertSee('Assigned At');
});

test('it removes pivot rows when deleting a course', function () {
    $course = Course::query()->create(['title' => 'Operating Systems']);

    $student = Student::query()->create([
        'fname' => 'Luis',
        'mname' => null,
        'lname' => 'Garcia',
        'contactno' => '09123456701',
        'email' => 'luis.garcia@example.com',
        'description' => 'Deletion pivot student',
    ]);

    $course->students()->sync([$student->id]);

    $response = $this->delete(route('courses.destroy', $course->id));

    $response->assertRedirect(route('courses.index'));
    $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    $this->assertDatabaseMissing('course_student', [
        'course_id' => $course->id,
        'student_id' => $student->id,
    ]);
});
