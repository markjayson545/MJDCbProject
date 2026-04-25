<?php

namespace App\Http\Controllers\Archived;

use DateTime;

class PSUController extends Controller
{
    public function welcome()
    {
        return view('psu.welcome');
    }

    public function mission()
    {
        return view('psu.mission');
    }

    public function vision()
    {
        return view("psu.vision");
    }

    public function EOMSPolicy()
    {
        return view('psu.eoms');
    }

    public function student($name, $course)
    {
        return view('student.student', [
            'name' => $name,
            'course' => $course,
            'date' => (new DateTime())->format('Y-m-d'),
        ]);
    }
}
