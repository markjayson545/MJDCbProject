<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Archived\Controller;
use App\Models\Degree;
use Illuminate\Http\Request;

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
        return view('admin.degree.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:degrees,name',
        ]);

        try {
            Degree::create([
                'name' => $request->input('name'),
            ]);
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
        $degree = Degree::find($id);
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
        $degree = Degree::find($id);
        if (! $degree) {
            return redirect()->route('admin.degrees.index')->with('error', 'Degree not found.');
        }

        return view('admin.degree.edit')->with('degree', $degree->toArray());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:degrees,name,'.$id,
        ]);

        $degree = Degree::find($id);
        if (! $degree) {
            return redirect()->route('admin.degrees.index')->with('error', 'Degree not found.');
        }

        try {
            $degree->update([
                'name' => $request->input('name'),
            ]);
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
