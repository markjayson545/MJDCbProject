<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display the student dashboard.
     */
    public function dashboard(int $id): \Illuminate\View\View
    {
        $student = Student::with(['courses', 'degree'])->findOrFail($id);

        return view('student_dashboard.student_dashboard', ['student' => $student]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'Displaying all students';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return 'Showing form to create student';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return 'Saving a new student';
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return "Displaying student with ID: $id";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return "Editing student with ID: $id";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return 'Updating student';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return 'Deleting student';
    }
}
