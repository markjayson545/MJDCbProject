<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function displayGreetings()
    {
        $name = 'Mark Jayson V. Dela Cruz';
        $address = 'Basista, Pangasinan';
        $grade = 90;
        $sex = 'Male';
        $client = [
            'name' => $name,
            'sex' => $sex,
            'address' => $address,
            'grade' => $grade,
        ];
        $students = [
            ['name' => 'Mark Jayson V. Dela Cruz', 'sex' => 'Male', 'address' => 'Basista, Pangasinan', 'grade' => 75.0, 'age' => 17],
            ['name' => 'Alexia Cayabyab', 'sex' => 'Female', 'address' => 'Calasiao, Pangasinan', 'grade' => 85.0, 'age' => 19],
            ['name' => 'Adrian Cabic', 'sex' => 'Male', 'address' => 'San Carlos, Pangasinan', 'grade' => 74.0, 'age' => 21],
        ];

        return view('client.greetings')->with('client', $client)->with('students', $students)->with('grade', $grade);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
