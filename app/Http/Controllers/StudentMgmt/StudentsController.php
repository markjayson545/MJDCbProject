<?php

namespace App\Http\Controllers\StudentMgmt;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Degree;
use App\Models\Student;
use App\Models\UserProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $students = Student::with(['degree', 'courses', 'userProfile'])->paginate(10);

        $students->getCollection()->transform(function ($s) {
            return $s->toArray();
        });
        Log::info('Fetched students list.', ['count' => $students->total()]);

        return view('student_mgmt.students')->with('students', $students);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $degrees = Degree::orderBy('name', 'asc')->get()->toArray();
        $courses = Course::orderBy('title', 'asc')->get()->toArray();
        $userProfiles = UserProfile::query()->whereDoesntHave('student')->orderBy('username')->get()->toArray();

        return view('student_mgmt.create')
            ->with('degrees', $degrees)
            ->with('courses', $courses)
            ->with('userProfiles', $userProfiles);
    }

    public function displayHome(): View
    {
        return view('student_mgmt.home');
    }

    public function displayStudents(): RedirectResponse
    {
        return redirect()->route('studentMgmt.index');
    }

    public function displayAbout(): View
    {
        return view('student_mgmt.about');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = \Validator::make($request->all(), [
            'fname' => 'required|string|max:255|min:2',
            'lname' => 'required|string|max:255|min:2',
            'contactno' => 'required|string|max:20|min:10',
            'email' => 'required|email',
            'description' => 'nullable|string',
            'degree_id' => 'nullable|integer|exists:degrees,id',
            'user_profile_id' => 'nullable|integer|exists:user_profiles,id|unique:students,user_profile_id',
            'course_ids' => 'nullable|array',
            'course_ids.*' => 'integer|exists:courses,id',
        ]);

        if ($validator->fails()) {
            Log::error('Failed to create student validation.', [
                'error' => $validator->errors()->first(),
            ]);

            return redirect()->route('studentMgmt.create')->withErrors($validator)->withInput();
        }

        try {
            $validated = $validator->validated();

            $student = Student::create([
                'fname' => $validated['fname'],
                'mname' => $validated['mname'] ?? null,
                'lname' => $validated['lname'],
                'contactno' => $validated['contactno'],
                'email' => $validated['email'],
                'description' => $validated['description'] ?? null,
                'degree_id' => $validated['degree_id'] ?? null,
                'user_profile_id' => $validated['user_profile_id'] ?? null,
            ]);

            $student->courses()->sync($validated['course_ids'] ?? []);

            Log::info('Created new student.', ['student_id' => $student->id]);
        } catch (\Throwable $throwable) {
            Log::error('Failed to create student.', ['error' => $throwable->getMessage()]);

            return redirect()->route('studentMgmt.create')->withInput()->with('error', 'Failed to create student: '.$throwable->getMessage());
        }

        return redirect()->route('studentMgmt.index')->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View|RedirectResponse
    {
        $student = Student::with(['degree', 'courses', 'userProfile'])->find($id);
        if (! $student) {
            return redirect()->route('studentMgmt.index')->with('error', 'Student not found.');
        }

        return view('student_mgmt.show')->with('student', $student->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|RedirectResponse
    {
        $student = Student::with(['courses', 'userProfile'])->find($id);
        if (! $student) {
            return redirect()->route('studentMgmt.index')->with('error', 'Student not found.');
        }

        $degrees = Degree::orderBy('name', 'asc')->get()->toArray();
        $courses = Course::orderBy('title', 'asc')->get()->toArray();
        $userProfiles = UserProfile::query()
            ->whereDoesntHave('student')
            ->orWhere('id', $student->user_profile_id)
            ->orderBy('username')
            ->get()
            ->toArray();

        return view('student_mgmt.edit')
            ->with('student', $student->toArray())
            ->with('degrees', $degrees)
            ->with('courses', $courses)
            ->with('userProfiles', $userProfiles);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validator = \Validator::make($request->all(), [
            'fname' => 'required|string|max:255|min:2',
            'lname' => 'required|string|max:255|min:2',
            'contactno' => 'required|string|max:20|min:10',
            'email' => 'required|email|unique:students,email,'.$id,
            'description' => 'nullable|string',
            'degree_id' => 'nullable|integer|exists:degrees,id',
            'user_profile_id' => 'nullable|integer|exists:user_profiles,id|unique:students,user_profile_id,'.$id,
            'course_ids' => 'nullable|array',
            'course_ids.*' => 'integer|exists:courses,id',
        ]);

        if ($validator->fails()) {
            Log::error('Failed to update student validation.', [
                'student_id' => $id,
                'error' => $validator->errors()->first(),
            ]);

            return redirect()->route('studentMgmt.edit', $id)->withErrors($validator)->withInput();
        }

        $student = Student::query()->find($id);

        if (! $student) {
            return redirect()->route('studentMgmt.index')->with('error', 'Student not found.');
        }

        try {
            $validated = $validator->validated();

            $student->update([
                'fname' => $validated['fname'],
                'mname' => $validated['mname'] ?? null,
                'lname' => $validated['lname'],
                'contactno' => $validated['contactno'],
                'email' => $validated['email'],
                'description' => $validated['description'] ?? null,
                'degree_id' => $validated['degree_id'] ?? null,
                'user_profile_id' => $validated['user_profile_id'] ?? null,
            ]);

            $student->courses()->sync($validated['course_ids'] ?? []);

            Log::info('Updated student.', ['student_id' => $id]);
        } catch (\Throwable $throwable) {
            Log::error('Failed to update student.', ['student_id' => $id, 'error' => $throwable->getMessage()]);

            return redirect()->route('studentMgmt.edit', $id)->with('error', 'Failed to update student: '.$throwable->getMessage());
        }

        return redirect()->route('studentMgmt.show', $id)->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $student = Student::query()->find($id);

        if (! $student) {
            return redirect()->route('studentMgmt.index')->with('error', 'Student not found.');
        }

        try {
            $student->courses()->detach();
            $student->delete();
        } catch (\Throwable $throwable) {
            return redirect()->route('studentMgmt.index')->with('error', 'Failed to delete student: '.$throwable->getMessage());
        }

        return redirect()->route('studentMgmt.index')->with('success', 'Student deleted successfully.');
    }
}
