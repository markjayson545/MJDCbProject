<?php

use App\Models\Course;
use App\Models\Degree;
use App\Models\MaintenanceSetting;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\UserAccount;
use App\Models\UserProfile;

it('seeds the medium demo dataset across active application tables', function () {
    $this->seed();

    expect(Degree::query()->count())->toBe(5)
        ->and(Course::query()->count())->toBe(20)
        ->and(Student::query()->count())->toBe(40)
        ->and(Teacher::query()->count())->toBe(10)
        ->and(UserProfile::query()->count())->toBe(40)
        ->and(UserAccount::query()->where('role', 'admin')->count())->toBe(1)
        ->and(UserAccount::query()->where('role', 'student')->count())->toBe(40)
        ->and(UserAccount::query()->where('role', 'teacher')->count())->toBe(10)
        ->and(MaintenanceSetting::query()->count())->toBe(1);
});

it('seeds relationship data for exports and dashboards', function () {
    $this->seed();

    $courseEnrollmentCount = Student::query()->withCount('courses')->get()->sum('courses_count');
    $teacherAssignmentCount = Teacher::query()->withCount('courses')->get()->sum('courses_count');
    $degreeSubjectCount = Degree::query()->withCount('courses')->get()->sum('courses_count');

    expect($courseEnrollmentCount)->toBe(160)
        ->and($teacherAssignmentCount)->toBe(20)
        ->and($degreeSubjectCount)->toBe(20)
        ->and(Student::query()->whereNotNull('user_account_id')->count())->toBe(40)
        ->and(Student::query()->whereNotNull('user_profile_id')->count())->toBe(40)
        ->and(Teacher::query()->whereNotNull('user_account_id')->count())->toBe(10);
});
