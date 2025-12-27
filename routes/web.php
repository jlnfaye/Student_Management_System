<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassController; // Assuming you have this

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider and all will be
| assigned to the "web" middleware group. Make something great!
|
*/

// Public routes (no auth required)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication routes (Breeze/Jetstream default)
require __DIR__.'/auth.php';

// Protected routes (authenticated + verified users only)
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Students - full CRUD + bulk delete
    Route::resource('students', StudentController::class);
    Route::post('students/bulk-destroy', [StudentController::class, 'bulkDestroy'])
        ->name('students.bulkDestroy');

    // Classes - full CRUD
    Route::resource('classes', ClassController::class);
});

// Optional redirect after login
Route::get('/home', function () {
    return redirect()->route('dashboard');
})->middleware(['auth', 'verified'])->name('home');