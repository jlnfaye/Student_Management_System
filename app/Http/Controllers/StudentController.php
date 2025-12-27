<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of students with search, sort, and class filter support.
     */
    public function index(Request $request)
    {
        $query = Student::query()->with('class');

        // Search by name, email, or address
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Filter by class
        if ($classId = $request->input('class_id')) {
            $query->where('class_id', $classId);
        }

        // Sorting
        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'desc');
        $direction = in_array($direction, ['asc', 'desc']) ? $direction : 'desc';

        if ($sort === 'class_name') {
            $query->join('classes', 'students.class_id', '=', 'classes.id')
                  ->orderBy('classes.name', $direction);
        } else {
            $query->orderBy($sort, $direction);
        }

        $students = $query->paginate(10)->appends($request->query());

        $classes = SchoolClass::all();

        return view('students.index', compact('students', 'search', 'sort', 'direction', 'classes', 'classId'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        $classes = SchoolClass::all();
        return view('students.create', compact('classes'));
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:students,email',
            'age'       => 'required|integer|min:16|max:100',
            'birthday'  => 'nullable|date|before_or_equal:today',
            'address'   => 'nullable|string|max:500',
            'class_id'  => 'nullable|exists:classes,id',
        ]);

        Student::create($validated);

        return redirect()->route('students.index')
            ->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified student.
     */
    public function show(Student $student)
    {
        $student->load('class');

        if (request()->expectsJson()) {
            return response()->json([
                'id'        => $student->id,
                'name'      => $student->name,
                'email'     => $student->email,
                'age'       => $student->age,
                'birthday'  => $student->birthday ? $student->birthday->format('d M Y') : null,
                'address'   => $student->address,
                'class'     => $student->class ? $student->class : null,
            ]);
        }

        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student)
    {
        $classes = SchoolClass::all();
        return view('students.edit', compact('student', 'classes'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => [
                'required',
                'email',
                Rule::unique('students')->ignore($student->id),
            ],
            'age'       => 'required|integer|min:16|max:100',
            'birthday'  => 'nullable|date|before_or_equal:today',
            'address'   => 'nullable|string|max:500',
            'class_id'  => 'nullable|exists:classes,id',
        ]);

        $student->update($validated);

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }

    /**
     * Bulk delete selected students.
     */
    public function bulkDestroy(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('students.index')
                ->with('error', 'Invalid request method.');
        }

        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        DB::transaction(function () use ($request) {
            Student::whereIn('id', $request->student_ids)->delete();
        });

        return redirect()->route('students.index')
            ->with('success', 'Selected students deleted successfully.');
    }
}