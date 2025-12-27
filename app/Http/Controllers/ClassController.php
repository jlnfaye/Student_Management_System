<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClassController extends Controller
{
    /**
     * Display a listing of classes with pagination and sorting.
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'desc');
        $direction = in_array($direction, ['asc', 'desc']) ? $direction : 'desc';

        $classes = SchoolClass::query()
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->appends($request->query());

        return view('classes.index', compact('classes', 'sort', 'direction'));
    }

    /**
     * Show the form for creating a new class.
     */
    public function create()
    {
        return view('classes.create');
    }

    /**
     * Store a newly created class in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'section' => 'nullable|string|max:10',
        ]);

        // Check if a class with the same name AND section already exists
        $exists = SchoolClass::where('name', $validated['name'])
            ->where('section', $validated['section'] ?? null)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['name' => 'A class with this name and section already exists.']);
        }

        SchoolClass::create($validated);

        return redirect()->route('classes.index')
            ->with('success', 'Class added successfully.');
    }

    /**
     * Show the form for editing the specified class.
     */
    public function edit(SchoolClass $class)
    {
        return view('classes.edit', compact('class'));
    }

    /**
     * Update the specified class in storage.
     */
    public function update(Request $request, SchoolClass $class)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'section' => 'nullable|string|max:10',
        ]);

        // Check uniqueness excluding the current class
        $exists = SchoolClass::where('name', $validated['name'])
            ->where('section', $validated['section'] ?? null)
            ->where('id', '!=', $class->id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['name' => 'A class with this name and section already exists.']);
        }

        $class->update($validated);

        return redirect()->route('classes.index')
            ->with('success', 'Class updated successfully.');
    }

    /**
     * Remove the specified class from storage.
     */
    public function destroy(SchoolClass $class)
    {
        $class->delete();

        return redirect()->route('classes.index')
            ->with('success', 'Class deleted successfully.');
    }
}