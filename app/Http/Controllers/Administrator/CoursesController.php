<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Archived\Controller;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $courses = Course::query()->withCount('students')->paginate(10);
        Log::info('Fetched courses list.', ['count' => $courses->total()]);

        return view('student_mgmt.course.courses')->with('courses', $courses);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('student_mgmt.course.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:courses,title',
        ]);

        try {
            $course = Course::query()->create([
                'title' => $request->input('title'),
            ]);

            Log::info('Created new course.', ['course_id' => $course->id, 'title' => $course->title]);
        } catch (\Throwable $throwable) {
            Log::error('Failed to create course.', ['error' => $throwable->getMessage()]);

            return redirect()->route('admin.courses.create')->with('error', 'Failed to create subject: '.$throwable->getMessage());
        }

        return redirect()->route('admin.courses.index')->with('success', 'Subject created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View|RedirectResponse
    {
        $course = Course::query()->with('students')->find($id);

        if (! $course) {
            Log::warning('Course not found on show.', ['course_id' => $id]);

            return redirect()->route('admin.courses.index')->with('error', 'Subject not found.');
        }

        return view('student_mgmt.course.show')->with('course', $course->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|RedirectResponse
    {
        $course = Course::query()
            ->with([
                'students' => function ($query) {
                    $query->orderBy('lname')->orderBy('fname');
                },
            ])
            ->withCount('students')
            ->find($id);

        if (! $course) {
            Log::warning('Course not found on edit.', ['course_id' => $id]);

            return redirect()->route('admin.courses.index')->with('error', 'Subject not found.');
        }

        $students = Student::query()
            ->orderBy('lname')
            ->orderBy('fname')
            ->get(['id', 'fname', 'lname', 'email'])
            ->toArray();

        return view('student_mgmt.course.edit')
            ->with('course', $course->toArray())
            ->with('students', $students);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:courses,title,'.$id,
            'student_ids' => 'nullable|array',
            'student_ids.*' => 'integer|exists:students,id',
        ]);

        $course = Course::query()->find($id);

        if (! $course) {
            Log::warning('Course not found on update.', ['course_id' => $id]);

            return redirect()->route('admin.courses.index')->with('error', 'Subject not found.');
        }

        try {
            $course->update([
                'title' => $validated['title'],
            ]);

            $course->students()->sync($validated['student_ids'] ?? []);

            Log::info('Updated course.', [
                'course_id' => $course->id,
                'title' => $course->title,
                'enrolled_students_count' => $course->students()->count(),
            ]);
        } catch (\Throwable $throwable) {
            Log::error('Failed to update course.', ['course_id' => $id, 'error' => $throwable->getMessage()]);

            return redirect()->route('admin.courses.edit', $id)->with('error', 'Failed to update subject: '.$throwable->getMessage());
        }

        return redirect()->route('admin.courses.edit', $id)->with('success', 'Subject updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $course = Course::query()->with('students')->find($id);

        if (! $course) {
            Log::warning('Course not found on delete.', ['course_id' => $id]);

            return redirect()->route('admin.courses.index')->with('error', 'Subject not found.');
        }

        try {
            $course->students()->detach();
            $course->delete();

            Log::info('Deleted course.', ['course_id' => $id]);
        } catch (\Throwable $throwable) {
            Log::error('Failed to delete course.', ['course_id' => $id, 'error' => $throwable->getMessage()]);

            return redirect()->route('admin.courses.index')->with('error', 'Failed to delete subject: '.$throwable->getMessage());
        }

        return redirect()->route('admin.courses.index')->with('success', 'Subject deleted successfully.');
    }
}
