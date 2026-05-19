<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Archived\Controller;
use App\Http\Requests\StudentMgmt\StoreDegreeRequest;
use App\Http\Requests\StudentMgmt\UpdateDegreeRequest;
use App\Models\Course;
use App\Models\Degree;

class DegreesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $degrees = Degree::paginate(10);

        return view('admin.degree.degrees')->with('degrees', $degrees);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::query()->orderBy('title')->get()->toArray();

        return view('admin.degree.add')->with('courses', $courses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDegreeRequest $request)
    {
        $validated = $request->validated();

        try {
            $degree = Degree::query()->create([
                'name' => $validated['name'],
            ]);

            $degree->courses()->sync($validated['course_ids'] ?? []);
        } catch (\Exception $e) {
            return redirect()->route('admin.degrees.create')->with('error', 'Failed to create degree: '.$e->getMessage());
        }

        return redirect()->route('admin.degrees.index')->with('success', 'Degree created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $degree = Degree::query()->with('courses')->find($id);
        if (! $degree) {
            return redirect()->route('admin.degrees.index')->with('error', 'Degree not found.');
        }

        return view('admin.degree.show')->with('degree', $degree->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $degree = Degree::query()->with('courses')->find($id);
        if (! $degree) {
            return redirect()->route('admin.degrees.index')->with('error', 'Degree not found.');
        }

        $courses = Course::query()->orderBy('title')->get()->toArray();

        return view('admin.degree.edit')
            ->with('degree', $degree->toArray())
            ->with('courses', $courses);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDegreeRequest $request, string $id)
    {
        $degree = Degree::query()->find($id);
        if (! $degree) {
            return redirect()->route('admin.degrees.index')->with('error', 'Degree not found.');
        }

        $validated = $request->validated();

        try {
            $degree->update([
                'name' => $validated['name'],
            ]);

            $degree->courses()->sync($validated['course_ids'] ?? []);
        } catch (\Throwable $th) {
            return redirect()->route('admin.degrees.edit', $id)->with('error', 'Failed to update degree: '.$th->getMessage());
        }

        return redirect()->route('admin.degrees.edit', $id)->with('success', 'Degree updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Degree::destroy($id);
        } catch (\Exception $e) {
            return redirect()->route('admin.degrees.index')->with('error', 'Failed to delete degree: '.$e->getMessage());
        }

        return redirect()->route('admin.degrees.index')->with('success', 'Degree deleted successfully.');
    }
}
