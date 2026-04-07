<?php

namespace App\Http\Controllers\StudentMgmt;

use App\Http\Controllers\Controller;
use App\Models\Degree;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Join students with degree table to get degree name, and paginate results
        $students = Student::with('degree')->paginate(2);
        // Add degree names to each student record for easier access in the view
        $students->getCollection()->transform(function ($s) {
            return $s->toArray();
        });
        error_log('Fetched students with degrees: '.json_encode($students));

        return view('student_mgmt.students')->with('students', $students);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $degrees = Degree::orderBy('name')->get()->toArray();

        return view('student_mgmt.create')->with('degrees', $degrees);
    }

    public function displayHome()
    {
        return view('student_mgmt.home');
    }

    public function displayStudents()
    {
        // Ensure the legacy display route uses the same paginated index view so pagination links are available.
        return redirect()->route('studentMgmt.index');
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
        try {
            $request->validate([
                'fname' => 'required|string|max:255',
                'mname' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'contactno' => 'required|string|max:20',
                'email' => 'required|email',
                'description' => 'nullable|string',
                'degree_id' => 'nullable|integer|exists:degrees,id',
            ]);

            Student::create([
                'fname' => $request->input('fname'),
                'mname' => $request->input('mname'),
                'lname' => $request->input('lname'),
                'contactno' => $request->input('contactno'),
                'email' => $request->input('email'),
                'description' => $request->input('description'),
                'degree_id' => $request->input('degree_id'),
            ]);
        } catch (\Exception $e) {
            return redirect()->route('studentMgmt.create')->with('error', 'Failed to create student: '.$e->getMessage());
        }

        return redirect()->route('studentMgmt.index')->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::with('degree')->find($id);
        if (! $student) {
            return redirect()->route('studentMgmt.index')->with('error', 'Student not found.');
        }

        return view('student_mgmt.show')->with('student', $student->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::find($id);
        if (! $student) {
            return redirect()->route('studentMgmt.index')->with('error', 'Student not found.');
        }
        $degrees = Degree::orderBy('name')->get()->toArray();

        return view('student_mgmt.edit')->with('student', $student->toArray())->with('degrees', $degrees);
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
                'email' => 'required|email|unique:students,email,'.$id,
                'description' => 'nullable|string',
                'degree_id' => 'nullable|integer|exists:degrees,id',
            ]);

            $student = Student::find($id);
            if (! $student) {
                return redirect()->route('studentMgmt.index')->with('error', 'Student not found.');
            }
            $student->update([
                'fname' => $request->input('fname'),
                'mname' => $request->input('mname'),
                'lname' => $request->input('lname'),
                'contactno' => $request->input('contactno'),
                'email' => $request->input('email'),
                'description' => $request->input('description'),
                'degree_id' => $request->input('degree_id'),
            ]);

            return redirect()->route('studentMgmt.edit', $id)->with('success', 'Student updated successfully.');

        } catch (\Throwable $th) {
            return redirect()->route('studentMgmt.edit', $id)->with('error', 'Failed to update student: '.$th->getMessage());
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
            return redirect()->route('studentMgmt.index')->with('error', 'Failed to delete student: '.$e->getMessage());
        }

        return redirect()->route('studentMgmt.index')->with('success', 'Student deleted successfully.');
    }
}
