<?php

use App\Models\Course;
use App\Models\Degree;

test('it syncs subjects when creating a degree', function () {
    $courseA = Course::query()->create(['title' => 'Web Development']);
    $courseB = Course::query()->create(['title' => 'Database Systems']);

    $response = $this->post(route('admin.degrees.store'), [
        'name' => 'Bachelor of Science in Information Technology',
        'course_ids' => [$courseA->id, $courseB->id],
    ]);

    $degree = Degree::query()->where('name', 'Bachelor of Science in Information Technology')->first();

    $response->assertRedirect(route('admin.degrees.index'));
    expect($degree)->not->toBeNull();

    $this->assertDatabaseHas('degree_subject', [
        'degree_id' => $degree->id,
        'course_id' => $courseA->id,
    ]);
    $this->assertDatabaseHas('degree_subject', [
        'degree_id' => $degree->id,
        'course_id' => $courseB->id,
    ]);
});

test('it syncs subjects when updating a degree', function () {
    $degree = Degree::query()->create(['name' => 'Bachelor of Science in Computer Science']);

    $existingCourse = Course::query()->create(['title' => 'Discrete Mathematics']);
    $newCourseA = Course::query()->create(['title' => 'Data Structures']);
    $newCourseB = Course::query()->create(['title' => 'Operating Systems']);

    $degree->courses()->sync([$existingCourse->id]);

    $response = $this->put(route('admin.degrees.update', $degree->id), [
        'name' => 'Bachelor of Science in Computer Science (Updated)',
        'course_ids' => [$newCourseA->id, $newCourseB->id],
    ]);

    $response->assertRedirect(route('admin.degrees.edit', $degree->id));

    $this->assertDatabaseHas('degrees', [
        'id' => $degree->id,
        'name' => 'Bachelor of Science in Computer Science (Updated)',
    ]);
    $this->assertDatabaseHas('degree_subject', [
        'degree_id' => $degree->id,
        'course_id' => $newCourseA->id,
    ]);
    $this->assertDatabaseHas('degree_subject', [
        'degree_id' => $degree->id,
        'course_id' => $newCourseB->id,
    ]);
    $this->assertDatabaseMissing('degree_subject', [
        'degree_id' => $degree->id,
        'course_id' => $existingCourse->id,
    ]);
});
