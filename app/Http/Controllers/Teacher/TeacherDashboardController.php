<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Archived\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $teacherId = $request->session()->get('teacher_id');

        $teacher = Teacher::query()
            ->with('courses')
            ->findOrFail($teacherId);

        $courses = $teacher->courses()->withCount('students')->get();

        $courseCount = $courses->count();
        $studentCount = $courses->sum(function ($course) {
            return $course->students_count;
        });
        $avgClassSize = $courseCount > 0 ? round($studentCount / $courseCount, 1) : 0;

        $request->session()->put('teacher', $teacher);

        return view('teacher.teacher_dashboard', compact(
            'teacher',
            'courses',
            'courseCount',
            'studentCount',
            'avgClassSize'
        ));
    }
}
