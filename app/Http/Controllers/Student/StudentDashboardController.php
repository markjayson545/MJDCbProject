<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Archived\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $studentId = $request->session()->get('student_id');

        $student = Student::query()
            ->with(['courses', 'degree'])
            ->findOrFail($studentId);

        $request->session()->put('student', $student);

        return view('student.student_dashboard');
    }
}
