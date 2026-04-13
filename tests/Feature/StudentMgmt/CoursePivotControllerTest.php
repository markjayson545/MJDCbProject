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

    $response->assertSuccessful()
        ->assertSee('Students (Pivot)')
        ->assertSee('Santos, Ana')
        ->assertSee('Assigned At');
});

test('it displays enrollment management details on course edit page', function () {
    $course = Course::query()->create(['title' => 'Computer Networks']);

    $enrolledStudent = Student::query()->create([
        'fname' => 'Carla',
        'mname' => null,
        'lname' => 'Gomez',
        'contactno' => '09123456710',
        'email' => 'carla.gomez@example.com',
        'description' => 'Enrolled student',
    ]);

    $availableStudent = Student::query()->create([
        'fname' => 'Marco',
        'mname' => null,
        'lname' => 'Reyes',
        'contactno' => '09123456711',
        'email' => 'marco.reyes@example.com',
        'description' => 'Available student',
    ]);

    $course->students()->sync([$enrolledStudent->id]);

    $response = $this->get(route('courses.edit', $course->id));

    $response->assertSuccessful()
        ->assertSee('Manage Enrolled Students')
        ->assertSee('Currently Enrolled')
        ->assertSee('Total Students')
        ->assertSee('Gomez, Carla')
        ->assertSee('Reyes, Marco')
        ->assertSee('View Student');
});

test('it syncs enrolled students when updating a course', function () {
    $course = Course::query()->create(['title' => 'Programming 1']);

    $existingStudent = Student::query()->create([
        'fname' => 'Ivy',
        'mname' => null,
        'lname' => 'Tan',
        'contactno' => '09123456712',
        'email' => 'ivy.tan@example.com',
        'description' => 'Existing enrollment',
    ]);

    $newStudentA = Student::query()->create([
        'fname' => 'Jules',
        'mname' => null,
        'lname' => 'Lim',
        'contactno' => '09123456713',
        'email' => 'jules.lim@example.com',
        'description' => 'New enrollment A',
    ]);

    $newStudentB = Student::query()->create([
        'fname' => 'Nico',
        'mname' => null,
        'lname' => 'Uy',
        'contactno' => '09123456714',
        'email' => 'nico.uy@example.com',
        'description' => 'New enrollment B',
    ]);

    $course->students()->sync([$existingStudent->id]);

    $response = $this->put(route('courses.update', $course->id), [
        'title' => 'Programming 1A',
        'student_ids' => [$newStudentA->id, $newStudentB->id],
    ]);

    $response->assertRedirect(route('courses.edit', $course->id));

    $this->assertDatabaseHas('courses', [
        'id' => $course->id,
        'title' => 'Programming 1A',
    ]);
    $this->assertDatabaseHas('course_student', [
        'course_id' => $course->id,
        'student_id' => $newStudentA->id,
    ]);
    $this->assertDatabaseHas('course_student', [
        'course_id' => $course->id,
        'student_id' => $newStudentB->id,
    ]);
    $this->assertDatabaseMissing('course_student', [
        'course_id' => $course->id,
        'student_id' => $existingStudent->id,
    ]);
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
