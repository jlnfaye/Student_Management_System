<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\ActivityLog; // <--- Import ActivityLog
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Stats for the Top Cards
        $totalStudents = Student::count();
        $totalClasses = SchoolClass::count();
        
        // "Active" students (assigned to a class)
        $activeStudents = Student::whereNotNull('class_id')->count(); 
        
        // Students added this month
        $newStudents = Student::whereMonth('created_at', now()->month)
                              ->whereYear('created_at', now()->year)
                              ->count();

        // 2. Fetch the 5 most recent activities
        $activities = ActivityLog::with('user')
                                 ->latest()
                                 ->take(5)
                                 ->get();

        return view('dashboard', compact(
            'totalStudents', 
            'totalClasses', 
            'activeStudents', 
            'newStudents', 
            'activities'
        ));
    }
}