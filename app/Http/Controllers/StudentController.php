<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of students with search, sort, and class filter support.
     */
    public function index(Request $request)
    {
        $query = Student::query()->with('class');

        // Search by name, email, address, OR Student ID
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('student_id_number', 'like', "%{$search}%"); // <--- Added ID Search
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

        // --- NEW: AJAX Check for Live Search ---
        if ($request->ajax()) {
            return view('students.partials.table', compact('students'))->render();
        }
        // ---------------------------------------

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
            // Enforce exactly 7 digits and uniqueness
            'student_id_number' => 'required|numeric|digits:7|unique:students,student_id_number', 
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:students,email',
            'age'       => 'required|integer|min:16|max:100',
            'birthday'  => 'nullable|date|before_or_equal:today',
            'address'   => 'nullable|string|max:500',
            'class_id'  => 'nullable|exists:classes,id',
            'student_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle Image Upload
        if ($request->hasFile('student_photo')) {
            $path = $request->file('student_photo')->store('student_photos', 'public');
            $validated['student_photo'] = $path;
        }

        // Save Student
        $student = Student::create($validated);

        // --- RECORD ACTIVITY LOG ---
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action'  => 'Created Student',
            'description' => 'Added new student: ' . $student->name . ' (ID: ' . $student->student_id_number . ')',
        ]);
        // ---------------------------

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
                'student_id_number' => $student->student_id_number,
                'name'      => $student->name,
                'email'     => $student->email,
                'age'       => $student->age,
                'birthday'  => $student->birthday ? $student->birthday->format('d M Y') : null,
                'address'   => $student->address,
                'class'     => $student->class ? $student->class : null,
                'student_photo' => $student->student_photo ? asset('storage/' . $student->student_photo) : null,
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
            // Enforce 7 digits, but ignore this student's own ID
            'student_id_number' => 'required|numeric|digits:7|unique:students,student_id_number,' . $student->id,
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
            'student_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle Image Upload during Update
        if ($request->hasFile('student_photo')) {
            // Delete old photo if it exists
            if ($student->student_photo) {
                Storage::disk('public')->delete($student->student_photo);
            }
            
            $path = $request->file('student_photo')->store('student_photos', 'public');
            $validated['student_photo'] = $path;
        }

        $student->update($validated);

        // --- RECORD ACTIVITY LOG ---
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action'  => 'Updated Student',
            'description' => 'Updated details for: ' . $student->name,
        ]);
        // ---------------------------

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Student $student)
    {
        $name = $student->name; // Save name for the log

        // Delete photo when student is deleted
        if ($student->student_photo) {
            Storage::disk('public')->delete($student->student_photo);
        }

        $student->delete();

        // --- RECORD ACTIVITY LOG ---
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action'  => 'Deleted Student',
            'description' => 'Deleted student: ' . $name,
        ]);
        // ---------------------------

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

        $count = count($request->student_ids); // Count for the log

        DB::transaction(function () use ($request) {
            // Fetch students first to delete their photos
            $studentsToDelete = Student::whereIn('id', $request->student_ids)->get();
            
            foreach ($studentsToDelete as $student) {
                if ($student->student_photo) {
                    Storage::disk('public')->delete($student->student_photo);
                }
            }

            Student::whereIn('id', $request->student_ids)->delete();
        });

        // --- RECORD ACTIVITY LOG (Bulk) ---
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action'  => 'Bulk Deleted',
            'description' => 'Deleted ' . $count . ' students via bulk action.',
        ]);
        // ----------------------------------

        return redirect()->route('students.index')
            ->with('success', 'Selected students deleted successfully.');
    }
}