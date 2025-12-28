<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassController;
use App\Models\ActivityLog; 
use App\Models\Student;
use App\Models\SchoolClass;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication routes
require __DIR__.'/auth.php';

// Protected routes
Route::middleware(['auth', 'verified'])->group(function () {
    
    // --- DASHBOARD LOGIC ---
    Route::get('/dashboard', function () {
        // 1. Get Stats
        $totalStudents = Student::count();
        $totalClasses = SchoolClass::count();
        $activeStudents = Student::whereNotNull('class_id')->count();
        $newStudents = Student::whereMonth('created_at', now()->month)->count();

        // 2. Get Recent Activity (Top 5)
        $activities = ActivityLog::with('user')->latest()->take(5)->get();

        // 3. Send to view
        return view('dashboard', compact(
            'totalStudents', 
            'totalClasses', 
            'activeStudents', 
            'newStudents', 
            'activities'
        ));
    })->name('dashboard');

    // --- ACTIVITY LOGS (VIEW ALL) ---
    Route::get('/activity-logs', function () {
        // Fetch all logs, 20 per page
        $activities = ActivityLog::with('user')->latest()->paginate(20);
        return view('activity_logs.index', compact('activities'));
    })->name('activity_logs.index');

    // Students
    Route::resource('students', StudentController::class);
    Route::post('students/bulk-destroy', [StudentController::class, 'bulkDestroy'])
        ->name('students.bulkDestroy');

    // Classes
    Route::resource('classes', ClassController::class);
});

// Redirect /home to /dashboard
Route::get('/home', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'verified']);