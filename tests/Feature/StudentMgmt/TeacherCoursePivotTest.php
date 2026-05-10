<?php

use App\Models\Course;
use App\Models\Teacher;

it('assigns a teacher to a course through the pivot table', function () {
    $teacher = Teacher::factory()->create();
    $course = Course::factory()->create();

    $teacher->courses()->attach($course->id);

    $this->assertDatabaseHas('course_teacher', [
        'teacher_id' => $teacher->id,
        'course_id' => $course->id,
    ]);
    expect($course->teachers()->count())->toBe(1);
});

it('avoids duplicate course assignments for the same teacher', function () {
    $teacher = Teacher::factory()->create();
    $course = Course::factory()->create();

    $teacher->courses()->syncWithoutDetaching([$course->id]);
    $teacher->courses()->syncWithoutDetaching([$course->id]);

    $this->assertDatabaseCount('course_teacher', 1);
});
