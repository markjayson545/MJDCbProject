<?php

namespace App\Http\Controllers\StudentMgmt;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::paginate(2);
        return view('student_mgmt.students', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('student_mgmt.create');
    }

    public function displayHome()
    {
        return view('student_mgmt.home');
    }

    public function displayStudents()
    {
        $students = [
//            ['name' => 'Mark Jayson Dela Cruz', 'age' => '20', 'course' => 'BSIT'],
//            ['name' => 'Alexia Cayabyab', 'age' => '19', 'course' => 'BSCS'],
//            ['name' => 'Adrian Cabic', 'age' => '21', 'course' => 'BSIS'],
        ];
        return view('student_mgmt.students')->with('students', $students);
    }

    public function displayAbout()
    {
        return view('student_mgmt.about');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Non eloquent way to create a student
        // $student = new Student();
        // $student->fname = $request->input('fname');
        // $student->mname = $request->input('mname');
        // $student->lname = $request->input('lname');
        // $student->contactno = $request->input('contactno');
        // $student->email = $request->input('email');
        // $student->description = $request->input('description');
        // $student->save();
        try {
            $request->validate([
                'fname' => 'required|string|max:255',
                'mname' => 'nullable|string|max:255',
                'lname' => 'required|string|max:255',
                'contactno' => 'required|string|max:20',
                'email' => 'required|email|unique:students,email',
                'description' => 'nullable|string',
            ]);

            Student::create([
                'fname' => $request->input('fname'),
                'mname' => $request->input('mname'),
                'lname' => $request->input('lname'),
                'contactno' => $request->input('contactno'),
                'email' => $request->input('email'),
                'description' => $request->input('description'),
            ]);
        } catch (\Exception $e) {
            return redirect()->route('studentMgmt.create')->with('error', 'Failed to create student: ' . $e->getMessage());
        }
        return redirect()->route('studentMgmt.create')->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return redirect()->route('studentMgmt.index')->with('error', 'Student not found.');
        }
        return view('student_mgmt.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('student_mgmt.edit')->with('student', Student::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'fname' => 'required|string|max:255',
                'mname' => 'nullable|string|max:255',
                'lname' => 'required|string|max:255',
                'contactno' => 'required|string|max:20',
                'email' => 'required|email|unique:students,email,' . $id,
                'description' => 'nullable|string',
            ]);

            $student = Student::find($id);
            if (!$student) {
                return redirect()->route('studentMgmt.index')->with('error', 'Student not found.');
            }
            $student->update([
                'fname' => $request->input('fname'),
                'mname' => $request->input('mname'),
                'lname' => $request->input('lname'),
                'contactno' => $request->input('contactno'),
                'email' => $request->input('email'),
                'description' => $request->input('description'),
            ]);
            return redirect()->route('studentMgmt.edit', $id)->with('success', 'Student updated successfully.');

        } catch (\Throwable $th) {
            return redirect()->route('studentMgmt.edit', $id)->with('error', 'Failed to update student: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Student::destroy($id);
        } catch (\Exception $e) {
            return redirect()->route('studentMgmt.index')->with('error', 'Failed to delete student: ' . $e->getMessage());
        }
        return redirect()->route('studentMgmt.index')->with('success', 'Student deleted successfully.');
    }
}
